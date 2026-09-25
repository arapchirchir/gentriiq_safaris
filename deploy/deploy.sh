#!/bin/bash
# Usage: deploy/deploy.sh ["commit message"]
set -e

cd "$(dirname "$0")/.."

echo "Starting deployment..."

branch="$(git rev-parse --abbrev-ref HEAD)"
if [ "$branch" != "master" ]; then
    echo "ABORT: on branch '$branch'. Switch to master to deploy."
    exit 1
fi

echo "Building front-end assets..."
npm run build --silent

if [ -n "$(git status --porcelain)" ]; then
    echo "Changes to be committed:"
    git status --short

    message="$1"
    if [ -z "$message" ]; then
        read -r -p "Commit message [Deploy $(date '+%Y-%m-%d %H:%M')]: " message
        message="${message:-Deploy $(date '+%Y-%m-%d %H:%M')}"
    fi

    git add -A
    git commit -m "$message"
else
    echo "Working tree clean, nothing to commit."
fi

echo "Pushing to origin/master..."
git push origin master

ssh evntfy << 'EOF'
set -e

cd ~/gentriiq_safaris

echo "0. Checking production environment..."
grep -qx 'APP_ENV=production' .env || { echo "ABORT: APP_ENV must be production"; exit 1; }
grep -qx 'APP_DEBUG=false' .env || { echo "ABORT: APP_DEBUG must be false"; exit 1; }

echo "Maintenance mode enabled."
php artisan down

trap 'php artisan up' EXIT

echo "1. Pulling latest code..."
git pull origin master
rm -f public/hot

[ -L public/storage ] || php artisan storage:link

echo "2. Installing Composer dependencies..."
composer install --no-dev --prefer-dist --optimize-autoloader

echo "3. Running migrations..."
php artisan migrate --force

echo "4. Running seeders..."
# php artisan db:seed --force

echo "5. Clearing old caches..."
php artisan optimize:clear

echo "6. Optimize configuration..."
php artisan optimize

echo "Deployment finished successfully."
EOF
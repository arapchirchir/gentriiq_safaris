#!/bin/bash
set -e

echo "Starting deployment..."

echo "Checking front-end build is committed..."
npm run build --silent
if [ -n "$(git status --porcelain -- public/build)" ]; then
    echo "ABORT: public/build changed after rebuilding. Commit and push the new build, then deploy again."
    exit 1
fi

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

echo "6. Caching configuration..."
php artisan config:cache

echo "7. Caching routes..."
php artisan route:cache

echo "8. Caching views..."
php artisan view:cache

echo "Deployment finished successfully."
EOF
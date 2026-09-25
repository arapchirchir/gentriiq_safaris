#!/bin/bash
set -e

echo "Starting deployment..."

ssh evntfy << 'EOF'
set -e

cd ~/gentriiq_safaris

echo "0. Checking production environment..."
grep -qx 'APP_ENV=production' .env || { echo "ABORT: APP_ENV must be production"; exit 1; }
grep -qx 'APP_DEBUG=false' .env || { echo "ABORT: APP_DEBUG must be false"; exit 1; }

echo "1. Pulling latest code..."
git pull origin master
rm -f public/hot

echo "2. Installing Composer dependencies..."
composer install --no-dev --prefer-dist --optimize-autoloader

echo "3. Running migrations..."
# Never use migrate:fresh here — it drops every table, including customer inquiries.
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
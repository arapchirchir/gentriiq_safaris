#!/bin/bash
set -e

echo "Starting deployment..."

ssh evntfy << 'EOF'
set -e

cd ~/gentriiq_safaris

echo "1. Pulling latest code..."
git pull origin master

echo "2. Installing Composer dependencies..."
composer install --no-dev --prefer-dist --optimize-autoloader

echo "3. Running migrations..."
php artisan migrate --force

echo "4. Clearing old caches..."
php artisan optimize:clear

echo "5. Caching configuration..."
php artisan config:cache

echo "6. Caching routes..."
php artisan route:cache

echo "7. Caching views..."
php artisan view:cache

echo "Deployment finished successfully."
EOF
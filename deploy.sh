#!/usr/bin/env bash
#
# Production deployment script for Laravel + Inertia (Vue 3)
# Run from project root on the VPS after each release.
#
# Usage: ./deploy.sh
#

set -euo pipefail

PROJECT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$PROJECT_DIR"

echo "==> Deploying from: $PROJECT_DIR"

echo "==> Enabling maintenance mode..."
php artisan down

echo "==> Pulling latest code..."
git pull origin main

echo "==> Installing Composer dependencies (production)..."
composer install --optimize-autoloader --no-dev --no-interaction

echo "==> Installing NPM dependencies and building assets..."
npm install
npm run build

echo "==> Running database migrations..."
php artisan migrate --force

echo "==> Clearing and rebuilding Laravel caches..."
php artisan optimize:clear
php artisan optimize

echo "==> Disabling maintenance mode..."
php artisan up

echo "==> Deployment completed successfully."

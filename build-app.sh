#!/bin/bash
# Make sure this file has executable permissions, run `chmod +x build-app.sh`

# Exit the script if any command fails
set -e

# Build assets using NPM
npm run build

# Seeds the DFB with the roles
php artisan db:seed --class=RoleSeeder --force
# Clear cache
php artisan optimize:clear
# Cache the various components of the Laravel application

php artisan icons:cache
php artisan config:cache
php artisan event:cache
#php artisan route:cache
php artisan route:trans:cache
php artisan view:cache


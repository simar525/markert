#!/bin/bash

# Install Composer if it's not available
if [ ! -f composer.phar ]; then
  echo "Downloading Composer..."
  curl -sS https://getcomposer.org/installer | php
fi

# Install PHP dependencies
php composer.phar install --prefer-dist --no-ansi --no-interaction --no-scripts --no-progress

# Add any additional build steps if necessary
# For example:
# npm install
# npm run production

# Run Laravel optimization commands if needed
php artisan optimize
#!/bin/bash

# Ensure composer is installed
if ! [ -x "$(command -v composer)" ]; then
  echo 'Error: composer is not installed.' >&2
  exit 1
fi

# Copy .env.example to .env
cp .env.example .env

# Install PHP dependencies
composer install --prefer-dist --no-ansi --no-interaction --no-scripts --no-progress

# Generate application key
php artisan key:generate

# Optimize application
php artisan optimize
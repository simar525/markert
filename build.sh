#!/bin/bash

# Install Composer
if [ ! -f composer.phar ]; then
    echo "Downloading Composer..."
    curl -sS https://getcomposer.org/installer | php
fi
php composer.phar install --prefer-dist --no-ansi --no-interaction --no-scripts --no-progress
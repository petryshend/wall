#!/usr/bin/env bash

git pull --rebase
composer install
php bin/console doctrine:migrations:migrate --no-interaction
php bin/console cache:clear --env=prod
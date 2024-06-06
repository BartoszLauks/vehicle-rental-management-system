#!/usr/bin/env bash

rm -Rf var/cache/*

#mkdir ./config/jwt

COMPOSER_ALLOW_SUPERUSER=1 docker compose exec -T vehicle-rental-management-system-php composer self-update
COMPOSER_ALLOW_SUPERUSER=1 docker compose exec -T vehicle-rental-management-system-php composer update --no-interaction --classmap-authoritative --optimize-autoloader

docker compose exec -T vehicle-rental-management-system-php php bin/console doctrine:database:create --if-not-exists
docker compose exec -T vehicle-rental-management-system-php php bin/console doctrine:migrations:migrate --no-interaction

#JWT lexik
docker compose exec -T vehicle-rental-management-system-php php bin/console lexik:jwt:generate-keypair --overwrite

OS := $(shell uname)

install:
	sh ./install.sh

install_test:
	sh ./install-test.sh

migrate:
	docker compose exec -T vehicle-rental-management-system-php php bin/console doctrine:migrations:diff --no-interaction
	docker compose exec -T vehicle-rental-management-system-php php bin/console doctrine:migrations:migrate --no-interaction

diff_migrations:
	docker compose exec -T vehicle-rental-management-system-php php bin/console doctrine:migrations:diff --no-interaction

migrations:
	docker compose exec -T vehicle-rental-management-system-php php bin/console doctrine:migrations:migrate --no-interaction

composer_install:
	COMPOSER_ALLOW_SUPERUSER=1 docker compose exec -T vehicle-rental-management-system-php composer self-update
	COMPOSER_ALLOW_SUPERUSER=1 docker compose exec -T vehicle-rental-management-system-php composer install --no-interaction --classmap-authoritative --optimize-autoloader

composer_update:
	COMPOSER_ALLOW_SUPERUSER=1 docker compose exec -T vehicle-rental-management-system-php composer self-update
	COMPOSER_ALLOW_SUPERUSER=1 docker compose exec -T vehicle-rental-management-system-php composer update --no-interaction --classmap-authoritative --optimize-autoloader

build_dev_local:
	docker compose -f docker-compose.yaml -f docker-compose-dev.local.yaml build

start_dev_local:
ifeq ($(OS),Darwin)
	docker volume create --name=vehicle-rental-management-system-api-vendor-sync
	docker volume create --name=vehicle-rental-management-system-api-app-sync
	docker compose -f docker-compose.yaml -f docker-compose-dev.local.yaml up -d --remove-orphans
	docker-sync start
else
	docker compose up -d
endif

stop_dev_local:
ifeq ($(OS),Darwin)
	docker compose stop
	docker-sync stop
else
	docker composestop
endif

sync_clean:
ifeq ($(OS),Darwin)
	docker-sync clean
endif

build_prod:
	docker compose -f docker-compose.yaml -f docker-compose-prod.yaml build

start_prod:
	docker compose -f docker-compose.yaml -f docker-compose-prod.yaml up -d

build_stage:
	docker compose -f docker-compose.yaml -f docker-compose-stage.yaml build

start_stage:
	docker compose -f docker-compose.yaml -f docker-compose-stage.yaml up -d

build_dev:
	docker compose -f docker-compose.yaml -f docker-compose-dev.yaml build

start_dev:
	docker compose -f docker-compose.yaml -f docker-compose-dev.yaml up -d

build_test:
	docker compose -f docker-compose-dev-test.yaml build

start_test:
	docker compose -f docker-compose-dev-test.yaml up -d

stop_test:
	docker compose -f docker-compose-dev-test.yaml down

stop:
	docker compose down

execphp:
	docker compose exec vehicle-rental-management-system-php bash

execdb:
	docker compose exec vehicle-rental-management-system-mysql bash

analyse:
	vendor/bin/phpstan analyse

load_fixtures:
	docker compose exec -T vehicle-rental-management-system-php-test bin/console doctrine:schema:drop --env=test --force
	docker compose exec -T vehicle-rental-management-system-php-test bin/console doctrine:schema:update --env=test --force
	docker compose exec -T vehicle-rental-management-system-php-test bin/console doctrine:fixtures:load --env=test -n

run_tests:
	docker compose exec -T vehicle-rental-management-system-php-test vendor/bin/phpunit

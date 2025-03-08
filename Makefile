.PHONY: up down build install migrate test

up:
	docker-compose up -d

down:
	docker-compose down

build:
	docker-compose build

install:
	docker-compose exec php composer install

migrate:
	docker-compose exec php vendor/bin/doctrine-migrations migrate

test:
	docker-compose exec php vendor/bin/phpunit

init: build up install migrate
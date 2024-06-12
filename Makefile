build:
	docker compose build

up:
	docker compose up -d

stop:
	docker compose stop

test:
	docker compose exec php vendor/bin/phpunit

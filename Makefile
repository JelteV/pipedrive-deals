build:
	docker compose build

setup:
	docker compose exec php composer install
	docker compose exec php bin/console pipedrive:webhook:configure

up:
	docker compose up -d


stop:
	docker compose stop

test:
	docker compose exec php vendor/bin/phpunit

ngrok:
	ngrok http 8181

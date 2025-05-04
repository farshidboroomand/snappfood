COMPOSE := docker-compose
EXEC := $(COMPOSE) exec app
SHELL := /bin/bash

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down

lint:
	$(EXEC) composer analyse

lint-fix:
	$(EXEC) composer fixer

migrate-fresh:
	$(EXEC) php artisan migrate:fresh --seed

clear:
	$(EXEC) php artisan config:clear
	$(EXEC) php artisan route:clear
	$(EXEC) php artisan cache:clear

test:
	$(EXEC) composer test

api-doc:
	$(EXEC) composer generate-api-doc
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
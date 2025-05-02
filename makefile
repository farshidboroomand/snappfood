COMPOSE := docker-compose
EXEC := $(COMPOSE) exec app
SHELL := /bin/bash

up:
	$(COMPOSE) up -d

down:
	$(COMPOSE) down
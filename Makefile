#/bin/bash

ifneq (,$(wildcard .env))
	include .env
endif

DOCKER=docker-compose
CONSOLE=bin/console

ifeq (,$(wildcard /.dockerenv))
ifeq ($(APP_ENV),test)
	DOCKER_EXEC=$(DOCKER) exec -T app
else
	DOCKER_EXEC=$(DOCKER) exec app
endif
endif

define abortIfProduction
	$(if $(filter $(APP_ENV),production), $(error 'Você não pode executar esta ação no ambiente de Produção'))
endef

all: up install build

up:
	$(DOCKER) up -d --remove-orphans --force-recreate

down:
	$(DOCKER) down

install:
	$(DOCKER_EXEC) yarn install
ifeq ($(APP_ENV),production)
	$(DOCKER_EXEC) composer install --prefer-dist --no-dev --no-progress --no-suggest --optimize-autoloader --no-ansi --no-interaction --profile --no-plugins --verbose
else
	$(DOCKER_EXEC) composer install --prefer-dist --no-suggest --optimize-autoloader --no-ansi --no-interaction --profile --verbose
endif

build:
	$(DOCKER_EXEC) $(CONSOLE) doctrine:migrations:migrate --no-interaction --allow-no-migration
	$(DOCKER_EXEC) $(CONSOLE) doctrine:schema:validate

drop:
	$(call abortIfProduction)
	$(DOCKER_EXEC) $(CONSOLE) doctrine:schema:drop --force --full-database

seed:
	$(call abortIfProduction)
	$(DOCKER_EXEC) $(CONSOLE) doctrine:fixtures:load --append

test:
	$(call abortIfProduction)
	$(DOCKER_EXEC) bin/phpunit

reset: drop build

bash:
	$(DOCKER_EXEC) bash

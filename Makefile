COMPOSER_COMMAND:=bash

USER_ID:=$(shell id -u)
GROUP_ID:=$(shell id -g)

PHP_VERSION:=8.5

DOCKER_COMPOSE_PHP := PHP_VERSION=$(PHP_VERSION) \
	USER_ID=$(USER_ID) \
	GROUP_ID=$(GROUP_ID) \
	docker compose run --rm --interactive --tty php

composer:
	docker run --rm --interactive --tty \
		--volume ${PWD}:/app \
		--volume ~/.composer:/tmp \
		--user $(USER_ID):$(GROUP_ID) \
		--volume /etc/passwd:/etc/passwd:ro \
		--volume /etc/group:/etc/group:ro \
		composer:2.8 $(COMPOSER_COMMAND)

composer-install:
	make composer COMPOSER_COMMAND='install'

composer-validate:
	make composer COMPOSER_COMMAND='validate'

test-unit:
	$(DOCKER_COMPOSE_PHP) vendor/bin/phpunit

cs-fixer:
	$(DOCKER_COMPOSE_PHP) vendor/bin/php-cs-fixer fix --allow-risky=yes ./

phpstan:
	$(DOCKER_COMPOSE_PHP) vendor/bin/phpstan analyse

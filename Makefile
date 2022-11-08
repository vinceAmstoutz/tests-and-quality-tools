# —— Inspired by ———————————————————————————————————————————————————————————————
# https://www.strangebuzz.com/en/snippets/the-perfect-makefile-for-symfony
# https://github.com/dunglas/symfony-docker/blob/main/docs/makefile.md
# And me https://github.com/vinceAmstoutz

# Setup ————————————————————————————————————————————————————————————————————————
# Executables (local)
DOCKER_COMP = docker compose
DOCKER        = docker

# Docker containers
PHP_CONT = $(DOCKER_COMP) exec php

# Executables
PHP      = $(PHP_CONT) php
COMPOSER = $(PHP_CONT) composer
SYMFONY  = $(PHP_CONT) bin/console

# Executables: vendors
PHPUNIT       = $(PHP_CONT) bin/phpunit
PHPSTAN       = $(PHP_CONT) ./vendor/bin/phpstan
PHP_CS_FIXER  = $(PHP_CONT) ./tools/php-cs-fixer/vendor/bin/php-cs-fixer

# Misc
.DEFAULT_GOAL = help

## —— 🐳& SF Project Makefile ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader
	mkdir --parents tools/php-cs-fixer
	@$(COMPOSER) install --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer

update: ## Update dependencies according to the composer.json file
	@$(COMPOSER) update
	@$(COMPOSER) update --working-dir=tools/php-cs-fixer friendsofphp/php-cs-fixer

recipes: ## Check outdated recipes (Symfony Flex)
	@$(COMPOSER) recipes -o

## —— Symfony 🎵 ———————————————————————————————————————————————————————————————
sf: ## List all Symfony commands
	@$(SYMFONY)

cc: ## Clear the cache
	@$(SYMFONY) c:c

warmup: ## Warmup the cache
	@$(SYMFONY) cache:warmup

fix-perms: ## Fix permissions of all var files
	@chmod -R 777 var/*

assets: purge ## Install the assets with symlinks in the public folder
	@$(SYMFONY) assets:install public/  # Don't use "--symlink --relative" with a Docker env

purge: ## Purge cache and logs
	@rm -rf var/cache/* var/logs/*

## —— Docker 🐳 ————————————————————————————————————————————————————————————————
up: ## Start the docker hub
	$(DOCKER_COMP) up --detach

build: ## Builds the images
	$(DOCKER_COMP) build --pull --no-cache

down: ## Stop the docker hub
	$(DOCKER_COMP) down --remove-orphans

bash: ## Log into the PHP docker container
	@$(DOCKER_COMP) exec php sh

logs: ## Show live logs
	@$(DOCKER_COMP) logs --tail=0 --follow

check: ## Docker check php container
	@$(DOCKER) info > /dev/null 2>&1
	@echo PHP service STATUS : `$(DOCKER) inspect --format "{{json .State.Health.Status }}" tests-and-quality-tools-php-1`
	
## —— Project 🐝 ———————————————————————————————————————————————————————————————
bdd: ## Build the DB, control the schema validity, load fixtures and check the migration status (see --env option)
	@$(eval APP_ENV ?= dev)
	$(SYMFONY) doctrine:database:create --if-not-exists --env=$(APP_ENV)
	$(SYMFONY) doctrine:schema:drop --full-database --force --env=$(APP_ENV)
	$(SYMFONY) doctrine:migrations:migrate --no-interaction --env=$(APP_ENV)
	$(SYMFONY) doctrine:fixtures:load --no-interaction --env=$(APP_ENV)

## —— Tests ✅ —————————————————————————————————————————————————————————————————
test: phpunit.xml.dist ## Run PHP unit tests with optionnal suite and filter
	@$(eval testsuite ?= 'all')
	@$(eval filter ?= '.')
	@$(PHPUNIT) --testsuite=$(testsuite) --filter=$(filter) --stop-on-failure

test-all: phpunit.xml.dist ## Run all PHPUnit tests
	@$(PHPUNIT) --stop-on-failure

## —— Coding standards ✨ ——————————————————————————————————————————————————————
stan: ## Run PHPStan
	@$(PHPSTAN) analyse -c phpstan.neon.dist --memory-limit 1G

lint-php: ## Lint files with php-cs-fixer for src & tests folders
	@$(PHP_CS_FIXER) fix

## —— Code Quality reports 📊 ——————————————————————————————————————————————————
ci: ## Execute CI locally (For Windows, WSL is required)
	act
coverage: ## Create the code coverage report with PHPUnit
	$(PHP_CONT) env XDEBUG_MODE=coverage env MEMORY_LIMIT=-1 env XDEBUG_ENABLE=1 ./bin/phpunit --coverage-html=var/coverage
coverage-open:	
	open var/coverage/index.html
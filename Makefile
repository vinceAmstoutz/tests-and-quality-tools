# —— Inspired by ———————————————————————————————————————————————————————————————
# https://www.strangebuzz.com/en/snippets/the-perfect-makefile-for-symfony

# Setup ————————————————————————————————————————————————————————————————————————
# Parameters
HTTP_PORT     = 8000

# Executables
EXEC_PHP      = php
COMPOSER      = composer
YARN          = yarn

# Alias
SYMFONY       = $(EXEC_PHP) bin/console
# if you use Docker you can replace with: "docker-compose exec my_php_container $(EXEC_PHP) bin/console"

# Executables: vendors
PHPUNIT       = $(DOCKER_COMP) exec $(EXEC_PHP) bin/phpunit
PHPSTAN       = ./vendor/bin/phpstan
PHP_CS_FIXER  = ./tools/php-cs-fixer/vendor/bin/php-cs-fixer

# Executables: local only
SYMFONY_BIN   = symfony
DOCKER        = docker
DOCKER_COMP   = docker-compose

# Misc
.DEFAULT_GOAL = help
.PHONY        : # Not needed here, but you can put your all your targets to be sure
                # there is no name conflict between your files and your targets.

## —— 🐝 Project Makefile inspired by Strangebuzz 🐝 ———————————————————————————————————
help: ## Outputs this help screen
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

## —— Composer 🧙‍♂️ ————————————————————————————————————————————————————————————
install: composer.lock ## Install vendors according to the current composer.lock file
	@$(COMPOSER) install --no-progress --prefer-dist --optimize-autoloader

update: ## Update dependencies according to the composer.json file
	@$(COMPOSER) update

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

## —— Symfony binary 💻 ————————————————————————————————————————————————————————
cert-install: ## Install the local HTTPS certificates
	@$(SYMFONY_BIN) server:ca:install

serve: ## Serve the application with HTTPS support (add "--no-tls" to disable https)
	@$(SYMFONY_BIN) serve --daemon --port=$(HTTP_PORT)

unserve: ## Stop the webserver
	@$(SYMFONY_BIN) server:stop

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

## —— Project 🐝 ———————————————————————————————————————————————————————————————
start: up bdd serve ## Start docker, load fixtures and start the webserver
stop: down unserve ## Stop docker and the Symfony binary server

bdd: ## Build the DB, control the schema validity, load fixtures and check the migration status
	@$(SYMFONY) doctrine:cache:clear-metadata
	@$(SYMFONY) doctrine:database:create --if-not-exists
	@$(SYMFONY) doctrine:schema:drop --force
	@$(SYMFONY) doctrine:schema:create
	@$(SYMFONY) doctrine:schema:validate
	@$(SYMFONY) doctrine:fixtures:load --no-interaction

## —— Tests ✅ —————————————————————————————————————————————————————————————————
phpunit-test: phpunit.xml.dist ## Run PHP unit tests with optionnal suite and filter
	@$(eval testsuite ?= 'all')
	@$(eval filter ?= '.')
	@$(PHPUNIT) --testsuite=$(testsuite) --filter=$(filter) --stop-on-failure

phpunit-test-all: phpunit.xml.dist ## Run all PHPUnit tests
	@$(PHPUNIT) --stop-on-failure

## —— Coding standards ✨ ——————————————————————————————————————————————————————
cs: lint-php ## Run all coding standards checks

static-analysis: stan ## Run the static analysis (PHPStan)

stan: ## Run PHPStan
	@$(PHPSTAN) analyse -l 5 src tests

lint-php: ## Lint files with php-cs-fixer for src & tests folders
	@$(PHP_CS_FIXER) fix src --allow-risky=yes --dry-run
	@$(PHP_CS_FIXER) fix tests --allow-risky=yes --dry-run

## —— Yarn 🐱 / JavaScript —————————————————————————————————————————————————————
dev: ## Rebuild assets for the dev env
	@$(YARN) install --check-files
	@$(YARN) run encore dev

watch: ## Watch files and build assets when needed for the dev env
	@$(YARN) run encore dev --watch

encore: ## Build assets for production
	@$(YARN) run encore production

## —— Code Quality reports 📊 ——————————————————————————————————————————————————
coverage:  ## Code coverage report with PHPUnit & open the last code coverage HTML page
	XDEBUG_MODE=coverage memory_limit=-1 ./vendor/bin/phpunit --coverage-text
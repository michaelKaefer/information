# See ——————————————————————————————————————————————————————————————————————————
# http://fabien.potencier.org/symfony4-best-practices.html
# https://speakerdeck.com/mykiwi/outils-pour-ameliorer-la-vie-des-developpeurs-symfony?slide=47
# https://blog.theodo.fr/2018/05/why-you-need-a-makefile-on-your-project/
# https://www.strangebuzz.com/en/snippets/the-perfect-makefile-for-symfony

# Setup ————————————————————————————————————————————————————————————————————————
# Import environment variables
-include .env.local

# Make internals
SHELL := /bin/bash
.DEFAULT_GOAL := help
.PHONY: *

## —— Help ————————————————————————————————————
help: ## Show help
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' Makefile | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'

help-phive: ## Help for installing a PHAR used as a tool for development
	@printf "Example: copy PHP CS Fixer into the project's directory tools:\n\n\tsudo phive install --copy php-cs-fixer\n\n"

## —— Build ———————————————————————————————————
build-dev: composer-dev ## Initially build the package for local development

## —— Dependencies ————————————————————————————
composer-dev: ## Install PHP dependencies according to composer.lock for development
	composer install

composer-validate: ## Check if composer.json is valid
	composer validate --strict

security-check: ## Check whether the project's dependencies contain any known security vulnerability
	symfony check:security

## —— Tests ————————————————————
tests: ## Run tests
	symfony run vendor/bin/phpunit

code-coverage: ## Create HTML code coverage report in ./var/coverage/ (also shows the text coverage report in STDOUT).
	symfony run vendor/bin/phpunit --coverage-html var/coverage/ --coverage-text
	sensible-browser "file://$(shell pwd)/var/coverage/index.html"

## —— Static code analysis ————————————————————
cs-fixer-dry-run-stop: ## Lint PHP with CS Fixer (does not edit files, on errors exit with exit code; can be used during CI to refuse pull requests which do not adapt to the used code styles)
	php ./tools/php-cs-fixer fix --diff -vvv --dry-run --stop-on-violation --using-cache=no >/dev/null 2>&1

cs-fixer-dry-run: ## Lint PHP with CS Fixer (does not edit files)
	php ./tools/php-cs-fixer fix --diff -vvv --dry-run --using-cache=no

cs-fixer-fix: ## Lint PHP with CS Fixer and correct files with errors
	php ./tools/php-cs-fixer fix --diff -vvv

psalm-dry-run: ## Lint PHP with Psalm (do not edit files, on errors exit with exit code; can be used during CI to refuse pull requests which do not adapt to the used code styles)
	php ./tools/psalm --show-info=true

psalm: ## Lint PHP with Psalm and correct files with errors
	php ./tools/psalm --alter --issues=all

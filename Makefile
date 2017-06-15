.PHONY: help test install lint lint.fix server phinx coveralls

ENV ?= dev
COMPOSER_ARGS =
ifeq ($(ENV), prod)
	COMPOSER_ARGS=--prefer-dist --classmap-authoritative --optimize-autoloader --no-dev
endif

help: ## This help
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(TARGETS) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

test: ## PHPUnit all the code !
	./vendor/bin/phpunit --stderr

install: config.php vendor ## Install application

lint: install ## Vérifie le code
	./vendor/bin/php-cs-fixer fix --diff --dry-run -v

lint.fix: install ## Vérifie le code et le corrige tout seul
	./vendor/bin/php-cs-fixer fix --diff -v

server: ## Lance le serveur de dev
	php -S localhost:8080 -t public -d display_errors=1

migrate: install ## Migre la base de données
	./vendor/bin/phinx migrate

seed: install ## Lance le seeding de la base de données
	./vendor/bin/phinx seed:run

# Fichiers
vendor: composer.lock
	composer install $(COMPOSER_ARGS)

composer.lock: composer.json
	composer update $(COMPOSER_ARGS)

build/logs/coveralls-upload.json: build/logs/clover.xml
	./vendor/bin/coveralls

config.php: config.php.dist ## Génère le fichier de configuration
	cp config.php.dist config.php
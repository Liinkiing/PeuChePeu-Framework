test:
	./vendor/bin/phpunit --stderr

install:
	composer install --no-dev --optimize-autoloader

lint:
	./vendor/bin/php-cs-fixer fix --diff --dry-run -v

lint.fix:
	./vendor/bin/php-cs-fixer fix --diff -v

migrate:
	./vendor/bin/phinx migrate

seed:
	./vendor/bin/phinx seed:run

server:
	php -S localhost:8080 -t public -d display_errors=1

phinx.create:
	./vendor/bin/phinx create
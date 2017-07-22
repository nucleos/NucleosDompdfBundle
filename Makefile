cs:
	./vendor/bin/php-cs-fixer fix --verbose

cs_dry_run:
	./vendor/bin/php-cs-fixer fix --verbose --dry-run

lint:
	composer validate

test:
	./vendor/bin/phpunit -c phpunit.xml.dist --coverage-clover build/logs/clover.xml

phpstan:
	./vendor/bin/phpstan analyse -c phpstan.neon -l 5 src tests

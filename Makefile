.PHONY: lint test

all:
	@echo "Please choose a task."

lint:
	composer validate
	find . -name '*.yml' -not -path './vendor/*' -not -path './vendor-bin/*' -not -path './src/Resources/public/vendor/*' | xargs yaml-lint
	find . \( -name '*.xml' -or -name '*.xlf' \) \
		-not -path './vendor/*' -not -path './vendor-bin/*' -not -path './src/Resources/public/vendor/*' \
        | xargs -I'{}' xmllint --encode UTF-8 --output '{}' --format '{}'
	export PHP_CS_FIXER_IGNORE_ENV=1 && php	vendor/bin/php-cs-fixer fix --verbose
	git diff --exit-code

checkdeps:
	vendor/bin/composer-require-checker check composer.json

phpstan:
	vendor/bin/phpstan analyse

test:
	vendor/bin/phpunit -c phpunit.xml.dist --coverage-clover build/logs/clover.xml

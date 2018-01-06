.PHONY: lint test

all:
	@echo "Please choose a task."

lint:
	composer validate
	find . -name '*.yml' -not -path './vendor/*' -not -path './Resources/public/vendor/*' | xargs yaml-lint
	find . \( -name '*.xml' -or -name '*.xlf' \) \
		-not -path './vendor/*' -not -path './Resources/public/vendor/*' \
        | xargs -I'{}' xmllint --encode UTF-8 --output '{}' --format '{}'
	php-cs-fixer fix --verbose
	git diff --exit-code

phpstan:
	phpstan analyse -c phpstan.neon -l 4 src tests

test:
	phpunit -c phpunit.xml.dist --coverage-clover build/logs/clover.xml

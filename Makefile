.PHONY: lint test

all:
	@echo "Please choose a task."

lint:
	composer validate
	find . -name '*.yml' -not -path './vendor/*' -not -path './Resources/public/vendor/*' | xargs yaml-lint
	find . \( -name '*.xml' -or -name '*.xliff' \) \
		-not -path './vendor/*' -not -path './Resources/public/vendor/*' \
        | xargs -I'{}' xmllint --encode UTF-8 --output '{}' --format '{}'
	php-cs-fixer fix --verbose
    git diff --exit-code

test:
	./vendor/bin/phpunit

CSS_OBJS := $(wildcard assets/**/*.css)
JS_OBJS := $(wildcard assets/**/*.js)
PHP_VERSION = 7.2

.PHONY: all
all: vendor assets deploy

.PHONY: install
install: vendor assets

vendor: composer.lock
ifeq ($(APP_ENV),prod)
	composer install --no-dev --classmap-authoritative && touch $@
else
	composer install && touch $@
endif

.PHONY: assets
assets: node_modules public/build

node_modules: yarn.lock
	timeout -s KILL 240s yarn install --ignore-engines && touch $@

public/build: $(JS_OBJS) $(CSS_OBJS)
ifeq ($(NODE_ENV),production)
	yarn run encore production && touch $@
else
	yarn run encore dev && touch $@
endif

.PHONY: build
build:
	yarn encore dev

.PHONY: watch
watch:
	yarn encore dev --watch

.PHONY: cache-clear
cache-clear:
	rm -rf var/cache/*
	rm -rf public/media/*

.PHONY: cache-warmup
cache-warmup: cache-clear
	php bin/console cache:warmup

.PHONY: deploy
deploy:
	php bin/console doctrine:schema:update --force

.PHONY: lint
lint:
	composer validate
	php bin/console debug:translation en --only-missing
	vendor/bin/phpmd --suffixes php src/ text phpmd.xml
	vendor/bin/phan

.PHONY: test
test:
	vendor/bin/simple-phpunit
			
.PHONY: codeship-install
codeship-install:
	set -e
	# Setup PHP
	phpenv local $(PHP_VERSION)
	pear config-set cache_dir ${HOME}/cache/pear/cache
	printf "\n" | pecl install apcu

	# Install AST PHP extension
	git clone --branch 'v0.1.6' --single-branch --depth 1 git@github.com:nikic/php-ast.git
	cd php-ast && phpize && ./configure && make && make install
	echo "extension=ast.so" >> /home/rof/.phpenv/versions/$(PHP_VERSION)/etc/php.ini

	# Disable xdebug
	rm -f /home/rof/.phpenv/versions/$(PHP_VERSION)/etc/conf.d/xdebug.ini
	phpenv rehash

.PHONY: codeship-setup
codeship-setup: codeship-install vendor assets cache-clear deploy

.PHONY: codeship-lint
codeship-lint: lint

.PHONY: codeship-test
codeship-test: test

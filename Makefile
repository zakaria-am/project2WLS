help:
	@echo "\n${ORANGE}usage: make ${BLUE}COMMAND${NC}"
	@echo "\n${YELLOW}Commands:${NC}"
	@echo "  ${BLUE}php-cs-fixer          : ${LIGHT_BLUE}Check Symfony Coding standard.${NC}"
	@echo "  ${BLUE}clean                 : ${LIGHT_BLUE}Clean directories for reset.${NC}"
	@echo "  ${BLUE}c-install             : ${LIGHT_BLUE}Install PHP/SF4 dependencies with composer.${NC}"
	@echo "  ${BLUE}c-update              : ${LIGHT_BLUE}Update PHP/SF4 dependencies with composer.${NC}"
	@echo "  ${BLUE}start                 : ${LIGHT_BLUE}Create and start containers.${NC}"
	@echo "  ${BLUE}stop                  : ${LIGHT_BLUE}Stop and clear all services.${NC}"
	@echo "  ${BLUE}logs                  : ${LIGHT_BLUE}Follow log output.${NC}"

init:
	@echo "${BLUE}Project configuration initialization:${NC}"
	@$(shell cp -n $(shell pwd)/docker-compose.yml.dist $(shell pwd)/docker-compose.yml 2> /dev/null)
	@$(shell cp -n $(shell pwd)/backend/composer.json.dist $(shell pwd)/backend/composer.json 2> /dev/null)

clean:
	@echo "${BLUE}Clean directories:${NC}"
	@rm -Rf docker-compose.yml
	@rm -Rf backend/composer.json
	@rm -Rf backend/composer.lock
	@rm -Rf backend/symfony.lock
	@rm -Rf backend/vendor
	@rm -Rf backend/var
	@rm -Rf backend/.php_cs.caches
	@rm -Rf ie-api/.env.local
	@rm -Rf ie-api/config/jwt

c-update:
	@echo "${BLUE}Updating your application dependencies:${NC}"
	@docker-compose exec -T php composer update

c-install:
	@echo "${BLUE}Installing your application dependencies:${NC}"
	@docker-compose exec -T php composer install

start: init
	@echo "${BLUE}Starting all containers:${NC}"
	@docker-compose up -d

stop:
	@echo "${BLUE}Stopping all containers:${NC}"
	@docker-compose down -v

d-m-m:
	@docker-compose exec -T php bin/console d:m:m --no-interaction

d-f-l:
	@mkdir -p ie-api/public/tmp
	@docker-compose exec -T php bin/console doctrine:fixtures:load --env=test --purge-with-truncate --no-interaction

phpunit-tests:
	@mkdir -p ie-api/reports/
	@docker-compose exec -T php bin/simple-phpunit --group=unitTest --coverage-html reports/

logs:
	@docker-compose logs -f

# Shell colors.
RED=\033[0;31m
LIGHT_RED=\033[1;31m
GREEN=\033[0;32m
LIGHT_GREEN=\033[1;32m
ORANGE=\033[0;33m
YELLOW=\033[1;33m
BLUE=\033[0;34m
LIGHT_BLUE=\033[1;34m
PURPLE=\033[0;35m
LIGHT_PURPLE=\033[1;35m
CYAN=\033[0;36m
LIGHT_CYAN=\033[1;36m
NC=\033[0m

.PHONY: clean test php-cs-fixer init
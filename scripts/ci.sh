PURPLE='\033[0;35m'
NC='\033[0m' # No Color

echo -e "${PURPLE}#### COMPOSER INSTALL ####${NC}"
composer install --no-interaction --no-progress
echo -e "${PURPLE}#### CHECK SECURITY PHP VENDOR ####${NC}"
php bin/console check:security
echo -e "${PURPLE}#### DOCTRINE MAPPING SYNC ####${NC}"
php bin/console doctrine:schema:validate --skip-sync -vvv --no-interaction
echo -e "${PURPLE}#### LINTER TWIG ####${NC}"
php bin/console lint:twig templates
echo -e "${PURPLE}#### LINTER CONFIG ####${NC}"
php bin/console lint:yaml config --parse-tags
echo -e "${PURPLE}#### LINTER CONTAINER ####${NC}"
php bin/console lint:container --no-debug
echo -e "${PURPLE}#### PHP CS FIXER ####${NC}"
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix --dry-run -v
echo -e "${PURPLE}#### PHP STAN ####${NC}"
vendor/bin/phpstan analyse
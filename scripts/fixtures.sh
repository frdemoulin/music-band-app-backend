PURPLE='\033[0;35m'
NC='\033[0m' # No Color

echo "${PURPLE}#### DROP DATABASE SCHEMA ####${NC}"
php -d memory_limit=-1 bin/console doctrine:schema:drop --force --no-interaction
echo "${PURPLE}#### SCHEMA CREATE ####${NC}"
php -d memory_limit=-1 bin/console doctrine:schema:create --no-interaction
echo "${PURPLE}#### SCHEMA VALIDATE ####${NC}"
php -d memory_limit=-1 bin/console doctrine:schema:validate --skip-sync -vvv --no-interaction
echo "${PURPLE}#### EXECUTE MIGRATIONS ####${NC}"
php -d memory_limit=-1 bin/console doctrine:migrations:migrate --no-interaction
echo "${PURPLE}#### GENERATE FIXTURES ####${NC}"
php -d memory_limit=-1 bin/console --env=dev doctrine:fixtures:load --no-interaction
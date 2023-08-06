PURPLE='\033[0;35m'
NC='\033[0m' # No Color

echo -e "${PURPLE}#### PHP CS FIXER ####${NC}"
tools/php-cs-fixer/vendor/bin/php-cs-fixer fix -vvv
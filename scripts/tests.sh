./vendor/bin/phpunit --testdox --testsuite entity,FrontTest,adminBackoffice 
yes | php bin/console --env=test doctrine:fixtures:load
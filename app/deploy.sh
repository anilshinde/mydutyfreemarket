#!/bin/bash

cd /var/www/mydutyfreemarket/ && composer install
cd /var/www/mydutyfreemarket/ && composer dump-autoload --optimize --no-dev --classmap-authoritative
cd /var/www/mydutyfreemarket/app/Resources/ && npm install 
cd /var/www/mydutyfreemarket/app/Resources/ && bower install

cd /var/www/mydutyfreemarket/ && php bin/console cache:clear --env=prod
cd /var/www/mydutyfreemarket/ && php bin/console assets:install --symlink web/ 
cd /var/www/mydutyfreemarket/ && php bin/console assetic:dump --env=prod --no-debug

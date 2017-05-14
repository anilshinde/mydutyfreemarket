#!/bin/bash
cd /var/www/mydutyfreemarket/ && composer install
cd /var/www/mydutyfreemarket/app/Resources/ && npm install && bower install

php bin/console cache:clear --env=prod
sudo php bin/console assets:install --symlink web/ && php bin/console assetic:dump --env=prod --no-debug

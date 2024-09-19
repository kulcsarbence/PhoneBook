#!/bin/bash

cd /var/www/html

composer install

until mysql -h"$DB_HOST" -u"$DB_USERNAME" -p"$DB_PASSWORD" -e 'SELECT 1'; do
  >&2 echo "Database is unavailable - sleeping"
  sleep 5
done

vendor/bin/phinx migrate

apache2-foreground
#!/usr/bin/bash

basedir="."
if [ ! -f "$basedir/app/config/parameters.yml" ]
then
    cp "$basedir/app/config/parameters.yml~" "$basedir/app/config/parameters.yml" || exit
fi
php -v > /dev/null || exit
php "$basedir/bin/composer.phar" self-update || exit
php "$basedir/bin/composer.phar" install || exit
echo -e "\n[info] For update vendors, type:\n\tphp bin/conposer.phar update"

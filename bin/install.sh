#!/bin/bash

if [ ! -f "composer.json" ];
then
    echo "[error] You must execute this on a root directory with file 'composer.json'" >&2;
    exit 1;
fi;

basedir=".";
parametersfile="$basedir/app/config/parameters.yml";
if [ ! -f "$parametersfile" ];
then
    cp "$parametersfile~" "$parametersfile" || exit 0;
fi;
php -v > /dev/null || exit 1;
php "$basedir/bin/composer.phar" self-update || exit 1;
php "$basedir/bin/composer.phar" install || exit 1;
php "$basedir/app/console" bbcode:dump || exit 1;

echo -e "\n[info] For update vendors, type:\n\tphp bin/conposer.phar update";
echo -e "Finally go to:\n\thttp://$(hostname)/_configurator/";
exit 0;
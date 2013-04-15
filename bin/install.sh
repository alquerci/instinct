#!/bin/bash

php -v > /dev/null || exit 1;

__DIR__="$(php -r "echo dirname(realpath('$0'));")";
cd "$__DIR__/..";

parametersfile="$__DIR__/../app/config/parameters.yml";

if [ ! -f "$parametersfile" ]; then
  cp "$parametersfile~" "$parametersfile" || exit 0;
fi;

if [ ! -x "composer.phar" ]; then
  php -r "eval('?>'.file_get_contents('http://getcomposer.org/installer'));"
fi;

php "composer.phar" install || exit 1;

echo -e "\n[info] For update vendors, type:\n\tphp composer.phar update";
echo -e "Start the server:\n\tapp/console server:run localhost:8000";
echo -e "Finally go to:\n\thttp://localhost:8000/_configurator/";

exit 0;

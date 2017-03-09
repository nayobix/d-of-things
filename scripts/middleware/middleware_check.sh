#!/bin/bash

MIDDLEWARE_SCRIPT_HTML="/var/www/html/d-of-things/scripts/middleware/mqtt_to_http.php"
MIDDLEWARE_SCRIPT_HTDOCS="/var/www/htdocs/d-of-things/scripts/middleware/mqtt_to_http.php"
MIDDLEWARE_SCRIPT=$MIDDLEWARE_SCRIPT_HTML

DOFTHINGS_DIR_HTML="/var/www/html/d-of-things"
DOFTHINGS_DIR_HTDOCS="/var/www/htdocs/d-of-things"
DOFTHINGS_DIR=$DOFTHINGS_DIR_HTML

if [ ! -e $MIDDLEWARE_SCRIPT ]; then
	MIDDLEWARE_SCRIPT=$MIDDLEWARE_SCRIPT_HTDOCS
	DOFTHINGS_DIR=$DOFTHINGS_DIR_HTDOCS
fi

ps aux | grep mqtt_to_http.php | grep -v grep > /dev/null
if [ $? -ne  0 ]; then
        cd $DOFTHINGS_DIR
	/usr/bin/php -dextension=mosquitto.so $MIDDLEWARE_SCRIPT &
	echo "`date` - mqtt middleware restarted"
fi

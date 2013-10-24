#!/bin/bash
# This should be ran from inside the r/a/dio vagrant box:
# https://r-a-d.io/vagrant.box

if [ ! -f app/config/app.php ]; then
	cp app/config/app.php.sample app/config/app.php
fi

if [ ! -f app/config.database.php ]; then
	cp app/config/database.php.sample app/config/database.php
fi

echo "Edit app/config/app.php and app/config/database.php after this."

composer install

# done

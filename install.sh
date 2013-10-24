#!/bin/bash
# This should be ran from inside the r/a/dio vagrant box:
# https://r-a-d.io/vagrant.box

composer self-update

cp app/config/app.php.sample app/config/app.php
cp app/config/database.php.sample app/config/database.php

echo "Edit app/config/app.php and app/config/database.php after this."

composer install

# Done.

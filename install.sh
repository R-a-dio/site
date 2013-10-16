#!/bin/bash
# TODO:
# * detect OS for travis-ci installs (ubuntu vs debian repos)
# * allow selection of mariadb repo country
# * Use "stable" instead of "wheezy"?

# fix for scripts having shit CDPATH vars
set CDPATH="."
BASEPATH="/radio/www/"

# Needed for add-apt-repository
apt-get install -y python-software-properties

echo "Adding php5.5 dotdeb repo"
# PHP 5.5
add-apt-repository 'deb http://packages.dotdeb.org wheezy-php55 all'

echo "Adding percona toolkit repo"
# Percona Toolkit
add-apt-repository 'deb http://repo.percona.com/apt wheezy main'

echo "Adding MariaDB repo."
# MariaDB
add-apt-repository 'deb http://mirror.stshosting.co.uk/mariadb/repo/5.5/debian wheezy main'

echo "Updating + Upgrading your system packages. #YOLO"
apt-get update && apt-get upgrade -y

apt-get remove -y mysql-common
apt-get install -y mariadb-5.5-server
# Script will end here if you have a mysql conflict.
# Might need to be manual if you have multiple versions.

echo "Installing required packages"
apt-get install -y \
php5-fpm \
php5-cli \
php5-mcrypt \
php5-mysql \
nginx \
curl \
git

if [ ! -f /usr/local/bin/composer ]; then
    echo "Installing Composer"
    curl -sS https://getcomposer.org/installer | php
    mv ./composer.phar /usr/local/bin/composer
done


mkdir "${BASEPATH}/r-a-d.io/dev"
cd "${BASEPATH}/r-a-d.io/dev"

echo "Checking out the git repo"
git clone https://github.com/R-a-dio/site.git .
git checkout develop

# Installing errythang, including database (for now)
composer install
# artisan database install


# Adding r/a/dio's nginx config.
# If you use apache, you aren't getting support. Ever.
cp nginx.conf /etc/nginx/sites-available/r-a-d.io
cd /etc/nginx/sites-enabled
ln -s /etc/nginx/sites-available/r-a-d.io r-a-d.io

# Restarting nginx
service nginx restart

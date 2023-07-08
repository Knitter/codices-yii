#!/usr/bin/env bash

source /app/env/provision/common.sh
readonly PHP_VERSION=8.2
readonly IP=$2

#== Import script args ==

timezone=$(echo "$1")

#== Provision script ==

info "Provision-script user: `whoami`"

export DEBIAN_FRONTEND=noninteractive

info "Configure timezone"
timedatectl set-timezone ${timezone} --no-ask-password
echo "Done!"

echo "Update OS software"
echo "set grub-pc/install_devices /dev/sda" | debconf-communicate
apt-get update
apt-get upgrade -y

apt-get install -y debconf-utils lsb-release ca-certificates apt-transport-https software-properties-common curl gnupg
echo "Done!"

echo "PHP SURY Repo"
echo "deb https://packages.sury.org/php/ $(lsb_release -sc) main" | tee /etc/apt/sources.list.d/sury-php.list
wget -qO - https://packages.sury.org/php/apt.gpg | apt-key add -
echo "Done!"

echo "Updating new repos"
apt-get update
echo "Done!"

echo "Install additional software"
apt-get install -y vim php${PHP_VERSION}-curl php${PHP_VERSION}-cli php${PHP_VERSION}-intl php${PHP_VERSION}-gd \
php${PHP_VERSION}-fpm php${PHP_VERSION}-mbstring php${PHP_VERSION}-xml php${PHP_VERSION}-zip php${PHP_VERSION}-xdebug \
php${PHP_VERSION}-apcu php${PHP_VERSION}-pgsql php${PHP_VERSION}-soap unzip nginx git redis nodejs npm default-jre php-pcov
echo "Done!"

#info "Prepare root password for MySQL"
#debconf-set-selections <<< "mysql-community-server mysql-community-server/root-pass password \"''\""
# debconf-set-selections <<< "mysql-community-server mysql-community-server/re-root-pass password \"''\""
# echo "Done!"

# info "Update OS software"
# apt-get update
# apt-get upgrade -y

# info "Add ppa:ondrej/php"
# apt-get install -y python-software-properties
# apt-get update && apt-get upgrade -y
# add-apt-repository -y ppa:ondrej/php
#
# info "Install additional software"
# apt-get install -y php7.4-curl php7.4-cli php7.4-intl php7.4-mysqlnd php7.4-gd php7.4-fpm php7.4-mbstring php7.4-xml unzip nginx mysql-server-5.7 php7.4-xdebug
#
# info "Configure MySQL"
# sed -i "s/.*bind-address.*/bind-address = 0.0.0.0/" /etc/mysql/mysql.conf.d/mysqld.cnf
# mysql -uroot <<< "CREATE USER 'root'@'%' IDENTIFIED BY ''"
# mysql -uroot <<< "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%'"
# mysql -uroot <<< "DROP USER 'root'@'localhost'"
# mysql -uroot <<< "FLUSH PRIVILEGES"
# echo "Done!"
#
echo "Configure PHP and PHP-FPM"
sed -i 's/user = www-data/user = env/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = env/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = env/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/display_errors = Off/display_errors = On/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/memory_limit = 128M/memory_limit = 512M/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 256M/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/;max_input_vars = 1000/max_input_vars = 7500/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/;date.timezone = /date.timezone = "Europe/Lisbon"/g' /etc/php/${PHP_VERSION}/fpm/php.ini
ln -s /app/env/php/fpm-php.ini /etc/php/${PHP_VERSION}/fpm/php.ini
echo "Done!"

echo "Configure xdebug"
rm /etc/php/${PHP_VERSION}/mods-available/xdebug.ini
ln -s /app/php/xdebug.ini /etc/php/${PHP_VERSION}/mods-available/xdebug.ini
echo "Done!"

info "Configure NGINX"
sed -i 's/user www-data/user env/g' /etc/nginx/nginx.conf
echo "Done!"

echo "Enabling site configuration"
ln -s /app/env/nginx/app.conf /etc/nginx/sites-enabled/app.conf
rm /etc/nginx/sites-enabled/default
echo "Done!"

# info "Initailize databases for MySQL"
# mysql -uroot <<< "CREATE DATABASE yii2advanced"
# mysql -uroot <<< "CREATE DATABASE yii2advanced_test"
# echo "Done!"

info "Install composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
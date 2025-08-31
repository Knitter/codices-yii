#!/usr/bin/env bash

source /project/env/vagrant-provision/common.sh
PHP_VERSION=8.4

#== Import script args ==

#== Provision script ==

echo "Provision-script user: `whoami`"
export DEBIAN_FRONTEND=noninteractive

echo "Configure timezone"
timedatectl set-timezone Europe/Lisbon --no-ask-password
echo "Timezone set to Europe/Lisbon"

echo "Update OS software"
echo "set grub-pc/install_devices /dev/sda" | debconf-communicate
apt-get update
apt-get upgrade -y
echo "Done!"

echo "PHP SURY Repo"
LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php
LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/nginx
curl -sSLo /usr/share/keyrings/deb.sury.org-php.gpg https://packages.sury.org/php/apt.gpg
echo "Done!"

echo "Updating new repos"
apt update
echo "Done!"

echo "Install additional software"
apt install -y php${PHP_VERSION}-curl php${PHP_VERSION}-cli php${PHP_VERSION}-intl php${PHP_VERSION}-gd brotli php-pear \
php${PHP_VERSION}-fpm php${PHP_VERSION}-mbstring php${PHP_VERSION}-xml php${PHP_VERSION}-zip php${PHP_VERSION}-xdebug php${PHP_VERSION}-dev \
php${PHP_VERSION}-apcu php${PHP_VERSION}-pgsql php${PHP_VERSION}-soap unzip nginx git nodejs npm php-pcov php${PHP_VERSION}-tidy php8.4-sqlite3
echo "Done!"

echo "Verify selected PHP is the desired version"
update-alternatives --set php /usr/bin/php${PHP_VERSION}
update-alternatives --set php-config /usr/bin/php-config${PHP_VERSION}
update-alternatives --set phpize /usr/bin/phpize${PHP_VERSION}

echo "Configure PHP and PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/display_errors = Off/display_errors = On/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/;date.timezone = /date.timezone = "Europe/Lisbon"/g' /etc/php/${PHP_VERSION}/fpm/php.ini
# ln -s /project/env/php/fpm-php.ini /etc/php/${PHP_VERSION}/fpm/php.ini
echo "Done!"

echo "Configure xdebug and AST"
rm /etc/php/${PHP_VERSION}/mods-available/xdebug.ini
ln -s /project/env/php/xdebug.ini /etc/php/${PHP_VERSION}/mods-available/xdebug.ini

#pecl install ast
#sed -i '/^;extension=zip/a extension=ast.so' /etc/php/${PHP_VERSION}/cli/php.ini
#echo "Done!"

echo "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

echo "Enabling site configuration"
ln -s /project/env/nginx/app.conf /etc/nginx/sites-enabled/app.conf
rm /etc/nginx/sites-enabled/default
echo "Done!"

echo "Enabling composer"
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
echo "Done!"

echo "All Done!"
#!/usr/bin/env bash

source /app/config/env/provision/common.sh
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

#echo "Redis Official Repo"
#curl -fsSL https://packages.redis.io/gpg | gpg --dearmor -o /usr/share/keyrings/redis-archive-keyring.gpg
#echo "deb [signed-by=/usr/share/keyrings/redis-archive-keyring.gpg] https://packages.redis.io/deb $(lsb_release -cs) main" | tee /etc/apt/sources.list.d/redis.list
#echo "Done!"

echo "Updating new repos"
apt-get update
echo "Done!"

echo "Install additional software"
apt-get install -y php${PHP_VERSION}-curl php${PHP_VERSION}-cli php${PHP_VERSION}-intl php${PHP_VERSION}-gd brotli \
php${PHP_VERSION}-fpm php${PHP_VERSION}-mbstring php${PHP_VERSION}-xml php${PHP_VERSION}-zip php${PHP_VERSION}-xdebug \
php${PHP_VERSION}-apcu php${PHP_VERSION}-soap unzip nginx git nodejs npm default-jre php-pcov php${PHP_VERSION}-tidy
echo "Done!"

echo "Configure PHP and PHP-FPM"
sed -i 's/user = www-data/user = vagrant/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/group = www-data/group = vagrant/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/owner = www-data/owner = vagrant/g' /etc/php/${PHP_VERSION}/fpm/pool.d/www.conf
sed -i 's/display_errors = Off/display_errors = On/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/memory_limit = 128M/memory_limit = 512M/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/post_max_size = 8M/post_max_size = 256M/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/;max_input_vars = 1000/max_input_vars = 7500/g' /etc/php/${PHP_VERSION}/fpm/php.ini
sed -i 's/;date.timezone = /date.timezone = "Europe/Lisbon"/g' /etc/php/${PHP_VERSION}/fpm/php.ini
ln -s /etc/php/${PHP_VERSION}/fpm/php.ini /app/config/env/php/fpm-php.ini
echo "Done!"

echo "Configure xdebug"
rm /etc/php/${PHP_VERSION}/mods-available/xdebug.ini
ln -s /app/config/env/php/xdebug.ini /etc/php/${PHP_VERSION}/mods-available/xdebug.ini
echo "Done!"

echo "Configure NGINX"
sed -i 's/user www-data/user vagrant/g' /etc/nginx/nginx.conf
echo "Done!"

echo "Enabling site configuration"
ln -s /app/config/env/nginx/app.conf /etc/nginx/sites-enabled/app.conf
rm /etc/nginx/sites-enabled/default
echo "Done!"

echo "Enabling redis server, composer, tools and selemium"
#systemctl enable redis-server
curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
npm install selenium-standalone -g
selenium-standalone install
echo "Done!"

echo "Installing google-chrome-stable and chromium-chromedriver for selenium browser tests"
wget https://dl.google.com/linux/direct/google-chrome-stable_current_amd64.deb
sudo dpkg -i google-chrome-stable_current_amd64.deb
rm google-chrome-stable_current_amd64.deb
wget https://chromedriver.storage.googleapis.com/2.41/chromedriver_linux64.zip
unzip chromedriver_linux64.zip
sudo mv chromedriver /usr/bin/chromedriver
sudo chown root:root /usr/bin/chromedriver
sudo chmod +x /usr/bin/chromedriver
rm chromedriver_linux64.zip
echo "Done!"
echo "All Done!"

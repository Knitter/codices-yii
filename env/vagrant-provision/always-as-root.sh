#!/usr/bin/env bash

source /project/env/vagrant-provision/common.sh

PHP_VERSION=8.4

#== Provision script ==

info "Provision-script user: `whoami`"

info "Restart PHP & DB services"
systemctl restart php${PHP_VERSION}-fpm
systemctl restart nginx
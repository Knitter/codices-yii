#!/usr/bin/env bash

source /app/env/provision/common.sh

#== Provision script ==

info "Provision-script user: `whoami`"

info "Restart PHP & DB services"
systemctl restart php8.2-fpm
systemctl restart nginx
# systemctl restart mysql

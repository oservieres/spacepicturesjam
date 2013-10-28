#!/bin/bash

echo -e "\\033[1;32mAliases for lazy developers :\\033[0;39m"

function createAlias {
    alias ${1}="${2}"
    echo -e "\\033[1;34m${1} \\033[0;39m: ${3}"
}

createAlias "mysqlconnect" "mysql -uspacepicturesjam -pspacepicturesjam spacepicturesjam" "Connect to the mysql database"
createAlias "apacherestart" "sudo service apache2 restart" "Restart apache"
createAlias "asseticwatch" "php /vagrant/app/console assetic:dump --watch" "Launch assetic watch command for auto dump"
createAlias "cacheclear" "php /vagrant/app/console cache:clear" "Clear Symfony cache"
createAlias "messagesdump" "php /vagrant/app/console translation:update fr SPJ\GameBundle --dump-messages --output-format=\"yml\" --force --clean --no-backup" "Dump translation messages"

#!/bin/bash -e

sudo apt-get update -y

echo grub-pc grub-pc/install_devices multiselect /dev/sda | sudo debconf-set-selections
echo grub-pc grub-pc/install_devices_disks_changed multiselect /dev/sda | sudo debconf-set-selections

sudo apt-get upgrade -y -o dir::cache::archives="/vagrant/logs/apt-cache"

echo mysql-server-5.5 mysql-server/root_password password root | sudo debconf-set-selections
echo mysql-server-5.5 mysql-server/root_password_again password root | sudo debconf-set-selections

sudo apt-get install -y -o dir::cache::archives="/vagrant/logs/apt-cache" mysql-server-5.5 mysql-client-5.5
echo "create database spacepicturesjam ; GRANT ALL PRIVILEGES ON spacepicturesjam.* To 'spacepicturesjam'@'localhost' IDENTIFIED BY 'spacepicturesjam' ;" | mysql -u root -proot

sudo apt-get install -y -o dir::cache::archives="/vagrant/logs/apt-cache" tree curl apache2 php5-mysql php5 php5-cli php-pear php5-curl phpunit php5-intl php5-dev php5-gd php5-mcrypt git-core git

sudo cp /vagrant/etc/apache_local.conf /etc/apache2/sites-available/spacepicturesjam
ln -s parameters.yml.dist /vagrant/app/config/parameters.yml

rm -f /vagrant/logs/web/*.log

sudo a2enmod rewrite
sudo a2dissite 000-default
sudo a2ensite spacepicturesjam
sudo service apache2 restart

cd /vagrant
curl -s http://getcomposer.org/installer | php5
php composer.phar install
php composer.phar update

php app/console doctrine:migrations:migrate --no-interaction

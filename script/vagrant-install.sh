#!/bin/bash -e

#Before all, upgrade VM, using GRUB pre-configuration
echo grub-pc grub-pc/install_devices multiselect /dev/sda | sudo debconf-set-selections
echo grub-pc grub-pc/install_devices_disks_changed multiselect /dev/sda | sudo debconf-set-selections

sudo apt-get update -y
sudo apt-get upgrade -y

#Install MySQL and create database
echo mysql-server-5.5 mysql-server/root_password password root | sudo debconf-set-selections
echo mysql-server-5.5 mysql-server/root_password_again password root | sudo debconf-set-selections

sudo apt-get install -y mysql-server-5.5 mysql-client-5.5
echo "create database if not exists spacepicturesjam ; \
      GRANT ALL PRIVILEGES ON spacepicturesjam.* To 'spacepicturesjam'@'localhost' IDENTIFIED BY 'spacepicturesjam' ;" | mysql -u root -proot

#Install various stuff
sudo apt-get install -y tree curl apache2 php5-mysql php5 php5-cli php-pear php5-curl phpunit php5-intl php5-dev php5-gd php5-mcrypt git-core git acl

#Prepare Symfony2 cache and logs dir, out of NFS partition and readable/writable by both cli and web
mkdir /tmp/spj/
APACHEUSER=`ps aux | grep -E '[a]pache|[h]ttpd' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:$APACHEUSER:rwX -m u:vagrant:rwX /tmp/spj/
sudo setfacl -dR -m u:$APACHEUSER:rwX -m u:vagrant:rwX /tmp/spj/

#Configure apache
if [ ! -f /etc/apache2/sites-available/spacepicturesjam ]
then
    sudo ln -s /vagrant/etc/apache_local.conf /etc/apache2/sites-available/spacepicturesjam
fi

sudo a2enmod rewrite
sudo a2dissite 000-default
sudo a2ensite spacepicturesjam
sudo service apache2 restart

#Install Symfony vendors
cd /vagrant
curl -s http://getcomposer.org/installer | php5
php composer.phar install
php composer.phar update

#Setup db structure and fixtures
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load --no-interaction

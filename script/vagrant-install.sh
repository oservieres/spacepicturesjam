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
sudo apt-get install -y vim tree curl apache2 php5-mysql php5 php5-cli php5-curl php-pear php5-curl phpunit php5-intl php5-dev php5-gd php5-mcrypt git-core git acl

#Install phpunit
sudo pear config-set auto_discover 1
sudo pear install pear.phpunit.de/PHPUnit || echo "phpunit already installed"

#Enable apache autostart. Ugly I know
sudo rm /etc/rc.local
sudo ln -s /vagrant/etc/rc.local /etc/rc.local
sudo chmod +x /etc/rc.local

#Prepare Symfony2 cache and logs dir, out of NFS partition and readable/writable by both cli and web
VAR_DIR="/var/spacepicturesjam/"
sudo mkdir -p ${VAR_DIR}
APACHEUSER=`ps aux | grep -E '[a]pache|[h]ttpd' | grep -v root | head -1 | cut -d\  -f1`
sudo setfacl -R -m u:$APACHEUSER:rwX -m u:vagrant:rwX ${VAR_DIR}
sudo setfacl -dR -m u:$APACHEUSER:rwX -m u:vagrant:rwX ${VAR_DIR}

#Configure apache
if [ ! -f /etc/apache2/sites-available/spacepicturesjam ]
then
    sudo ln -s /vagrant/etc/apache_local.conf /etc/apache2/sites-available/spacepicturesjam
fi

sudo a2enmod rewrite
sudo a2dissite 000-default
sudo a2ensite spacepicturesjam
sudo service apache2 restart

#Install profile file
grep "source /vagrant/script/profile.sh" /home/vagrant/.bashrc || echo "source /vagrant/script/profile.sh" >> /home/vagrant/.bashrc

#Install Symfony vendors
cd /vagrant
curl -s http://getcomposer.org/installer | php5
php composer.phar install

#Setup db structure and fixtures
php app/console doctrine:migrations:migrate --no-interaction
php app/console doctrine:fixtures:load --no-interaction

#Install assets
php app/console assets:install --relative --symlink
php app/console assetic:dump

# Space Pictures Jam

## What is this project ?

I don't really know yet. The main idea was to keep contact with friends spreaded over Europe by playing a sort of game : choosing a random subject periodically, then everyone posting a photo illustrating it. So, we'll start simple, and improve it periodically.

## Requirements

 * Vagrant 1.3.4 (may work with older versions)
 * Virtualbox 4.2 (may work with older versions)
 * A NFS server

## Installation

    git clone git@github.com:oservieres/spacepicturesjam.git
    cd spacepicturesjam
    vagrant up

Then, go to **http://localhost:8080**. Before trying to sign up, you can use fixture users : **admin** (pass : admin) and **player** (pass : player).

If you modify css or js files, always run the following command on the VM to see your changes :

    php /vagrant/app/console assetic:dump --watch

## Requirements installation under ubuntu 12.04 LTS i386
    wget "http://download.virtualbox.org/virtualbox/4.2.18/virtualbox-4.2_4.2.18-88780~Ubuntu~precise_i386.deb"
    sudo dpkg -i virtualbox-4.2_4.2.18-88780~Ubuntu~precise_i386.deb
    wget "http://files.vagrantup.com/packages/0ac2a87388419b989c3c0d0318cc97df3b0ed27d/vagrant_1.3.4_i686.deb"
    sudo dpkg -i vagrant_1.3.4_i686.deb
    sudo apt-get install nfs-kernel-server

## FAQ

### Why i386 ?

I have an old laptop.

### Why everything (Apache, MySQL...) on the same VM ?

Same answer. Moreover, I wanted to start simple. My goal using Vagrant is not to have a perfect copy of the production environment, but an instantanely available development environment.

### Why bash and not Chef or Puppet

I am a Vagrant newbie. One thing at a time, I wanted to learn Vagrant with a well known language before trying something else.

### Why this project name ?

I love Space Jam

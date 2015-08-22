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
    docker-compose up

Then, go to **http://localhost**. Before trying to sign up, you can use fixture users : **admin** (pass : admin) and **player** (pass : player).

If you modify css or js files, always run the following command on the VM to see your changes :

    php app/console assetic:dump --watch


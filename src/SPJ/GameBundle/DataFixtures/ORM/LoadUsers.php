<?php

namespace SPJ\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use SPJ\GameBundle\Entity\User;

class LoadUserData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $encoder = $this->container
                        ->get('security.encoder_factory')
                        ->getEncoder(new User());

        $userAdmin = new User();
        $userAdmin->setUsername('admin')
                  ->setEmail('admin@spj.local.com')
                  ->setIsAdmin(true)
                  ->setPassword($encoder->encodePassword('admin', $userAdmin->getSalt()));
        $manager->persist($userAdmin);

        $userPlayer = new User();
        $userPlayer->setUsername('player')
                   ->setEmail('player@spj.local.com')
                   ->setPassword($encoder->encodePassword('player', $userPlayer->getSalt()));
        $manager->persist($userPlayer);

        $manager->flush();

        $this->addReference('user_admin', $userAdmin);
        $this->addReference('user_player', $userPlayer);
    }

    public function getOrder()
    {
        return 1;
    }
}


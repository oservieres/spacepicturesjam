<?php

namespace SPJ\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use SPJ\GameBundle\Entity\User;
use SPJ\GameBundle\Entity\Challenge;

class LoadUserData implements FixtureInterface, ContainerAwareInterface
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

        $inprogressChallenge = new Challenge();
        $inprogressChallenge->setStatus('inprogress')
                            ->setSubject('La Nuit');
        $manager->persist($inprogressChallenge);

        $manager->flush();
    }
}


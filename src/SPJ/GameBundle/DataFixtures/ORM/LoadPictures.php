<?php

namespace SPJ\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use SPJ\GameBundle\Entity\Picture;

class LoadPictureData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $votingPicture1 = new Picture();
        $votingPicture1->setDateCreated(new \DateTime())
                       ->setTitle('photo ouf')
                       ->setLocation('Lyon 9eme')
                       ->setDescription('photo de bla bla bla')
                       ->setFocalLength('250mm')
                       ->setAperture('f4.5')
                       ->setISO('800')
                       ->setShutterSpeed('1/345')
                       ->setPath('http://imageshack.com/scaled/800x600/163/yzsw.jpg')
                       ->setBlurredMiniaturePath('http://imageshack.com/scaled/800x600/707/42jg.jpg')
                       ->setMiniaturePath('http://imageshack.com/scaled/800x600/208/jw1q.jpg')
                       ->setChallenge($this->getReference('voting_challenge'))
                       ->setUser($this->getReference('user_player'));
        $manager->persist($votingPicture1);

        $votingPicture2 = new Picture();
        $votingPicture2->setDateCreated(new \DateTime())
                       ->setTitle('Hey hey')
                       ->setLocation('Berlin')
                       ->setDescription('photo de bla bli blo bla')
                       ->setFocalLength('50mm')
                       ->setAperture('f1.5')
                       ->setISO('200')
                       ->setShutterSpeed('1/100')
                       ->setPath('http://imageshack.com/scaled/800x600/163/yzsw.jpg')
                       ->setBlurredMiniaturePath('http://imageshack.com/scaled/800x600/707/42jg.jpg')
                       ->setMiniaturePath('http://imageshack.com/scaled/800x600/208/jw1q.jpg')
                       ->setChallenge($this->getReference('voting_challenge'))
                       ->setUser($this->getReference('user_admin'));
        $manager->persist($votingPicture2);

        $manager->flush();
    }

    public function getOrder()
    {
        return 3;
    }
}


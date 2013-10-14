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
        $votingPicture1 = $this->getPicture($this->getReference('voting_challenge'), $this->getReference('user_admin'));
        $manager->persist($votingPicture1);

        $votingPicture2 = $this->getPicture($this->getReference('voting_challenge'), $this->getReference('user_player'));
        $manager->persist($votingPicture2);

        $inprogressPicture1 = $this->getPicture($this->getReference('inprogress_challenge'), $this->getReference('user_admin'));
        $manager->persist($inprogressPicture1);

        $manager->flush();
    }

    public function getPicture($challenge, $user)
    {
        $picture = new Picture();
        $picture->setDateCreated(new \DateTime())
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
                ->setChallenge($challenge)
                ->setUser($user);
        return $picture;
    }

    public function getOrder()
    {
        return 3;
    }
}


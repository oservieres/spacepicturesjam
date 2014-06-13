<?php

namespace SPJ\GameBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;

use SPJ\GameBundle\Entity\Challenge;

class LoadChallengeData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
{
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $endDate = new \DateTime('today');
        $endDate->add(new \DateInterval('P14D'));

        $inprogressChallenge = new Challenge();
        $inprogressChallenge->setStatus('inprogress')
                            ->setEndDate($endDate)
                            ->setSubject('La Nuit');
        $manager->persist($inprogressChallenge);

        $previousEndDate = new \DateTime('today');
        $previousEndDate->sub(new \DateInterval('P1D'));

        $votingChallenge = new Challenge();
        $votingChallenge->setStatus('voting')
                        ->setEndDate($previousEndDate)
                        ->setEndVotingDate($endDate)
                        ->setSubject('Le jour');
        $manager->persist($votingChallenge);

        $overChallenge = new Challenge();
        $overChallenge->setStatus('over')
                      ->setSubject('L\'agitation');
        $manager->persist($overChallenge);

        $queuedChallenge1 = new Challenge();
        $queuedChallenge1->setStatus('queued')
                            ->setSubject('La mort');
        $manager->persist($queuedChallenge1);

        $queuedChallenge2 = new Challenge();
        $queuedChallenge2->setStatus('queued')
                         ->setSubject('Les pelles');
        $manager->persist($queuedChallenge2);

        $manager->flush();

        $this->addReference('inprogress_challenge', $inprogressChallenge);
        $this->addReference('voting_challenge', $votingChallenge);
        $this->addReference('over_challenge', $overChallenge);
    }

    public function getOrder()
    {
        return 1;
    }
}


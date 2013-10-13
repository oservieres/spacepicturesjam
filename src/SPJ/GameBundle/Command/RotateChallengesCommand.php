<?php

namespace SPJ\GameBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RotateChallengesCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('challenges:rotate')
            ->setDescription('Draws a new challenge, terminates the voting one');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $challengeRepository = $this->getContainer()->get('challenge_repository');
        $challengeDuration = $this->getContainer()->getParameter('challenge_duration');

        $inprogressChallenge = $challengeRepository->findOneInProgress();
        if (null !== $inprogressChallenge) {
            if ($inprogressChallenge->getEndDate() > new \DateTime()) {
                return;
            }
            $inprogressChallenge->setStatus('voting');
            $endVotingDate = new \DateTime('today');
            $endVotingDate->add(new \DateInterval('P' . $challengeDuration . 'D'));
            $inprogressChallenge->setEndDate($endVotingDate);
            $entityManager->persist($inprogressChallenge);
        }

        $votingChallenge = $challengeRepository->findOneVoting();
        if (null !== $votingChallenge) {
            $votingChallenge->setStatus('over');
            $entityManager->persist($votingChallenge);
        }

        $newChallenge = $challengeRepository->findOneRandomQueued();
        $newChallenge->setStatus('inprogress');
        $newChallenge->setStartDate(new \DateTime());
        $endDate = new \DateTime('today');
        $endDate->add(new \DateInterval('P' . $challengeDuration . 'D'));
        $newChallenge->setEndDate($endDate);
        $entityManager->persist($newChallenge);

        $entityManager->flush();
    }
}

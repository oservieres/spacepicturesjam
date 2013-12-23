<?php

namespace SPJ\GameBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PrepareChallengeResultEmailsCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('emails:challenge_result:prepare')
             ->setDescription('Prepares emails to send to people who played');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $challengeRepository = $this->getContainer()->get('challenge_repository');

        $challenge = $challengeRepository->findOneLatestOver();
    }
}

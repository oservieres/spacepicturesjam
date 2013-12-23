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
        $challenge = $this->getContainer()
                          ->get('challenge_repository')
                          ->findOneLatestOver();
        $users = $this->getContainer()
                      ->get('user_repository')
                      ->findBatchByChallenge($challenge);

        foreach ($users as $user) {
            $message = \Swift_Message::newInstance()
                     ->setSubject('Hello Email')
                     ->setFrom('send@example.com')
                     ->setTo('recipient@example.com')
                     ->setBody($this->getContainer()->get('templating')->render(
                         'SPJGameBundle:Email:challenge_result.html.twig',
                         array(
                             'user' => $user[0],
                             'challenge' => $challenge
                         )
                     ));
            $this->getContainer()->get('mailer')->send($message);
            $entityManager->detach($user[0]);
        }
    }
}

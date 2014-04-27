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
        $isVerbose = $input->getOption('verbose');
        $entityManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $overChallenge = $this->getContainer()
                          ->get('challenge_repository')
                          ->findOneLatestOver();
        $newChallenge = $this->getContainer()
                          ->get('challenge_repository')
                          ->findOneInprogress();
        $users = $this->getContainer()
                      ->get('user_repository')
                      ->findAllBatch();

        foreach ($users as $user) {
            $body = $this->getContainer()->get('templating')->render(
                'SPJGameBundle:Email:challenge_result.html.twig',
                array(
                    'user' => $user[0],
                    'overChallenge' => $overChallenge,
                    'newChallenge' => $newChallenge,
                )
            );
            $message = \Swift_Message::newInstance()
                     ->setSubject('Space Pictures Jam : nouveau challenge !')
                     ->setFrom('no-reply@spj.deudtens.com')
                     ->setTo($user[0]->getEmail())
                     ->setBody($body);
            $this->getContainer()->get('mailer')->send($message);
            if ($isVerbose) {
                var_dump($body);
            }
            $entityManager->detach($user[0]);
        }
    }
}

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
        $newChallenge = $this->getContainer()
                          ->get('challenge_repository')
                          ->findOneInprogress();
        if ($newChallenge->getStartDate()->diff(new \DateTime())->d > 1) {
            return;
        }
        $users = $this->getContainer()
                      ->get('user_repository')
                      ->findAllBatch();

        $templating = $this->getContainer()->get('templating');

        foreach ($users as $user) {
            $templateData = array(
                'user' => $user[0],
                'newChallenge' => $newChallenge,
            );
            $htmlBody = $templating->render(
                'SPJGameBundle:Email:challenge_result.html.twig',
                $templateData
            );
            $textBody = $templating->render(
                'SPJGameBundle:Email:challenge_result.html.twig',
                $templateData
            );

            $message = \Swift_Message::newInstance()
                     ->setSubject('Space Pictures Jam : nouveau challenge !')
                     ->setFrom('spacepicturesjam@gmail.com')
                     ->setTo($user[0]->getEmail())
                     ->setBody($htmlBody, 'text/html')
                     ->addPart($textBody, 'text/plain');
            ;
            $this->getContainer()->get('mailer')->send($message);
            if ($isVerbose) {
                var_dump($htmlBody);
            }
            $entityManager->detach($user[0]);
        }
    }
}

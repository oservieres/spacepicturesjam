<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ChallengeController extends Controller
{
    public function listAction()
    {
        return $this->render('SPJGameBundle:Challenge:list.html.twig');
    }

}

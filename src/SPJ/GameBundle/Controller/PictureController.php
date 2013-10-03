<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PictureController extends Controller
{
    public function createAction()
    {
        return $this->render(
            'SPJGameBundle:Picture:create.html.twig'
        );
    }

}

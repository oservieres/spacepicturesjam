<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SPJ\GameBundle\Entity\User;
use SPJ\GameBundle\Form\UserType;

class UserController extends Controller
{
    public function loginAction()
    {
        return $this->render(
            'SPJGameBundle:User:login.html.twig'
        );
    }

    public function signupAction()
    {
        $form = $this->createForm(new UserType(), new User(), array(
            'action' => $this->generateUrl('signup_check'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $this->render(
            'SPJGameBundle:User:signup.html.twig',
            array('form' => $form)
        );
    }

}

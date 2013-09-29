<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use SPJ\GameBundle\Entity\User;
use SPJ\GameBundle\Form\UserType;
use SPJ\GameBundle\Response\JsonResponse;

class UserController extends Controller
{
    public function loginAction()
    {
        return $this->render(
            'SPJGameBundle:User:login.html.twig'
        );
    }

    private function getSignupForm(User $user)
    {
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('signup_check'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    public function signupAction()
    {
        return $this->render(
            'SPJGameBundle:User:signup.html.twig',
            array(
                'form' => $this->getSignupForm(new User())->createView()
            )
        );
    }

    public function signupCheckAction(Request $request)
    {
        $user = new User();
        $form = $this->getSignupForm($user);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $passwordEncoder = $this->get('security.encoder_factory')->getEncoder($user);
            $user->setPassword($passwordEncoder->encodePassword($user->getpassword(), $user->getSalt()));

            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            $token = new UsernamePasswordToken($user, null, 'main', array('ROLE_USER'));
            $this->get('security.context')->setToken($token);

            return new JsonResponse(array('redirect_url' => '/'), 201);
        }
        return new JsonResponse(null, 403);
    }
}

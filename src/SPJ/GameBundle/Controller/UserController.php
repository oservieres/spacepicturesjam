<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

use SPJ\GameBundle\Entity\User;
use SPJ\GameBundle\Form\UserType;

class UserController extends Controller
{
    public function loginAction()
    {
        return $this->render(
            'SPJGameBundle:User:login.html.twig', array(
                'facebookLoginUrl' => $this->get('facebook')->getLoginUrl()
            )
        );
    }

    public function facebookLoginCheckAction(Request $request)
    {
        try {
            $this->get('facebook')->login();
        } catch (\Exception $e) {
            return $this->redirect($this->get('router')->generate('login'));
        }

        return $this->redirect($this->get('router')->generate('challenge_list'));
    }

    private function getSignupForm(User $user)
    {
        $form = $this->createForm(new UserType(), $user, array(
            'action' => $this->generateUrl('signup'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'user.signup.validate'));

        return $form;
    }

    public function signupAction(Request $request)
    {
        $user = new User();
        $form = $this->getSignupForm($user);
        $form->handleRequest($request);

        $errors = $this->get('validator')->validate($user);
        if (!$form->isValid() || 0 < sizeof($errors)) {
            return $this->render('SPJGameBundle:User:signup.html.twig', array(
                'facebookLoginUrl' => $this->get('facebook')->getLoginUrl(),
                'entity' => $user,
                'errors' => $errors,
                'form'   => $form->createView(),
            ));
        }
        $passwordEncoder = $this->get('security.encoder_factory')->getEncoder($user);
        $user->setPassword($passwordEncoder->encodePassword($user->getPassword(), $user->getSalt()));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        $token = new UsernamePasswordToken($user, null, 'main', array('ROLE_USER'));
        $this->get('security.context')->setToken($token);

        return $this->redirect($this->get('router')->generate('challenge_list'));
    }
}

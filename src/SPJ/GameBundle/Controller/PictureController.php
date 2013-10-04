<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SPJ\GameBundle\Entity\Picture;
use SPJ\GameBundle\Form\PictureType;

class PictureController extends Controller
{
    public function createAction(Request $request, $challengeId)
    {
        $picture = new Picture();
        $form = $this->createForm(new PictureType(), $picture, array(
            'action' => $this->generateUrl(
                'picture_create',
                array('challengeId' =>  $challengeId)
            ),
            'method' => 'POST',
        ));
        $form->add('submit', 'submit', array('label' => 'Create'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($picture);
            $em->flush();

            return $this->render('SPJGameBundle:Picture:created.html.twig');
        }

        return $this->render('SPJGameBundle:Picture:create.html.twig', array(
            'picture' => $picture,
            'form'   => $form->createView(),
        ));
    }

}

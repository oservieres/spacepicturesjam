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
        $user = $this->get('security.context')->getToken()->getUser();
        $challenge = $this->get('challenge_repository')->findOneById($challengeId);
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
            $pictureProperties = $this->get('picture_upload')->upload($picture->getFile());
            $picture->setPath($pictureProperties['path']);
            $picture->setMiniaturePath($pictureProperties['miniature_path']);
            $picture->setBlurredMiniaturePath($pictureProperties['blurred_miniature_path']);
            $picture->setDateCreated(new \DateTime());
            $picture->setUser($user);
            $picture->setChallenge($challenge);
            $picture->setExifProperties($pictureProperties['exif']);
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

    public function challengeListAction($challengeId, $page = 1)
    {
        $challenge = $this->get('challenge_repository')->findOneById($challengeId);
        return $this->render('SPJGameBundle:Picture:challenge_list.html.twig', array(
            'pictures' => $this->get('picture_repository')->findByChallenge($challenge),
            'challenge' => $challenge
        ));
    }

    public function challengeUserShowAction($challengeId)
    {
        $challenge = $this->get('challenge_repository')->findOneById($challengeId);
        $user = $this->get('security.context')->getToken()->getUser();

        if ("" !== $user) {
            $picture = $this->get('picture_repository')->findOneByChallengeAndUser($challenge, $user);
        } else {
            $picture = null;
        }
        $templateName = $challenge->getStatus() === 'inprogress' ? 'SPJGameBundle:Picture:challenge_user_show_inprogress.html.twig' : 'SPJGameBundle:Picture:challenge_user_show.html.twig';
        return $this->render($templateName, array(
            'picture' => $picture,
            'challenge' => $challenge
        ));
    }

}

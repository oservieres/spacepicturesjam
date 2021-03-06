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
        $form->add('submit', 'submit', array('label' => 'picture.create.validate'));

        $form->handleRequest($request);

        if ($form->isValid()) {
            $pictureProperties = $this->get('picture_upload')->upload($picture->getFile());
            $picture->setPath($pictureProperties['path']);
            $picture->setMiniaturePath($pictureProperties['miniature_path']);
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
        $pictures = $this->get('picture_repository')->findByChallenge($challenge);
        $picturesCount = $this->get('picture_repository')->findCountByChallenge($challenge);

        return $this->render(
            'SPJGameBundle:Picture:challenge_list.html.twig',
            array(
                'picturesCount' => $picturesCount,
                'pictures' => $pictures,
                'challenge' => $challenge
            )
        );
    }

    public function challengeUserShowAction($challengeId)
    {
        $challenge = $this->get('challenge_repository')->findOneById($challengeId);
        $user = $this->get('security.context')->getToken()->getUser();

        $picture = null;
        if ("" !== $user) {
            $picture = $this->get('picture_repository')->findOneByChallengeAndUser($challenge, $user);
        }

        $templateName = $challenge->getStatus() === 'inprogress' ?
            'SPJGameBundle:Picture:challenge_user_show_inprogress.html.twig' :
            'SPJGameBundle:Picture:challenge_user_show.html.twig';

        return $this->render(
            $templateName,
            array(
                'picture' => $picture,
                'challenge' => $challenge
            )
        );
    }

    public function showAction($pictureId)
    {
        $picture = $this->get('picture_repository')->findOneById($pictureId);
        $nextPicture = $this->get('picture_repository')->findOneNext($picture);
        $previousPicture = $this->get('picture_repository')->findOnePrevious($picture);
        $user = $this->get('security.context')->getToken()->getUser();
        $userRatingValue = "" === $user ? null : $this->get('rating_repository')->findValueByPictureAndUser($picture, $user);
        $comments = $this->get('comment_repository')->findByChallenge($picture->getChallenge());

        return $this->render(
            'SPJGameBundle:Picture:show.html.twig',
            array(
                'picture' => $picture,
                'comments' => $comments,
                'userRatingValue' => $userRatingValue,
                'nextPicture' => $nextPicture,
                'previousPicture' => $previousPicture
            )
        );
    }
}

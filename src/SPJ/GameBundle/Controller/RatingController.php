<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use SPJ\GameBundle\Response\GameJsonResponse;
use SPJ\GameBundle\Entity\Rating;

class RatingController extends Controller
{
    public function createAction($pictureId, Request $request)
    {
        $pictureRepository = $this->get('picture_repository');
        $user = $this->get('security.context')->getToken()->getUser();
        $picture = $pictureRepository->findOneById($pictureId);

        $ratingValue = $request->request->get('value');

        $em = $this->getDoctrine()->getManager();

        try {
            $rating = $this->get('rating_repository')->findOneByUserAndPicture($user, $picture);
            $pictureRepository->updateRating($picture, $rating->getValue(), $ratingValue);
        } catch (\Exception $e) {
            $pictureRepository->addRating($picture, $ratingValue);
            $rating = new Rating();
            $rating->setPicture($picture)
                   ->setDateCreated(new \DateTime())
                   ->setUser($user);
        }
        $rating->setValue($ratingValue);

        $em->persist($rating);
        $em->flush();

        return new GameJsonResponse(
            array(
                'rating' => array(
                    'value' => $rating->getValue()
                )
            ),
            201
        );
    }
}

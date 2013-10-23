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
        $user = $this->get('security.context')->getToken()->getUser();
        $picture = $this->get('picture_repository')->findOneById($pictureId);

        $em = $this->getDoctrine()->getManager();

        try {
            $rating = $this->get('rating_repository')->findOneByUserAndPicture($user, $picture);
        } catch (\Exception $e) {
            $rating = new Rating();
            $rating->setPicture($picture)
                   ->setUser($user);
        }
        $rating->setValue($request->request->get('value'))
               ->setDateCreated(new \DateTime());

        $em->persist($rating);
        $em->flush();

        return new GameJsonResponse(null, 201);
    }
}

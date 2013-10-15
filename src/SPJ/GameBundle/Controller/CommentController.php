<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

use SPJ\GameBundle\Response\GameJsonResponse;
use SPJ\GameBundle\Entity\Comment;

class CommentController extends Controller
{

    public function createAction($pictureId, Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $picture = $this->get('picture_repository')->findOneById($pictureId);

        $em = $this->getDoctrine()->getManager();

        $comment = new Comment();
        $comment->setContent($request->request->get('content'))
                ->setPicture($picture)
                ->setUser($user)
                ->setDateCreated(new \DateTime());

        $em->persist($comment);
        $em->flush();

        return new GameJsonResponse(array('comment' => $comment->getArrayData()), 201);
    }
}

<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use SPJ\GameBundle\Response\GameJsonResponse;
use SPJ\GameBundle\Entity\Comment;

class CommentController extends Controller
{

    public function createAction($challengeId, Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $challenge = $this->get('challenge_repository')->findOneById($challengeId);

        $em = $this->getDoctrine()->getManager();

        $comment = new Comment();
        $comment->setContent($request->request->get('content'))
                ->setChallenge($challenge)
                ->setUser($user)
                ->setDateCreated(new \DateTime());

        $em->persist($comment);
        $em->flush();

        return new GameJsonResponse(array('comment' => $comment->getArrayData()), 201);
    }

    public function challengeListAction($challengeId, Request $request)
    {
        $challenge = $this->get('challenge_repository')->findOneById($challengeId);
        $comments = $this->get('comment_repository')->findByChallenge($challenge);

        return $this->render(
            'SPJGameBundle:Comment:list.html.twig',
            array(
                'comments' => $comments
            )
        );
    }
}

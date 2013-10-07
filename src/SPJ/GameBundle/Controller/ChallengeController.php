<?php

namespace SPJ\GameBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use SPJ\GameBundle\Entity\Challenge;
use SPJ\GameBundle\Form\ChallengeType;

/**
 * Challenge controller.
 *
 */
class ChallengeController extends Controller
{

    public function listAction()
    {
        $challengeRepository = $this->get('challenge_repository');
        $user = $this->get('security.context')->getToken()->getUser();

        $overChallenges = $challengeRepository->findAllOver();
        $inprogressChallenge = $challengeRepository->findOneInProgress($user);
        $votingChallenge = $challengeRepository->findOneVoting($user);

        return $this->render(
            'SPJGameBundle:Challenge:list.html.twig',
            array(
                'inprogressChallenge' => $inprogressChallenge,
                'votingChallenge' => $votingChallenge,
                'overChallenges'      => $overChallenges,
                'inprogressUserPicture' => $user === "" ? "" : $this->get('picture_repository')->findOneByChallengeAndUser($inprogressChallenge, $user)
            )
        );
    }

    /**
     * Creates a new Challenge entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Challenge();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_challenge_show', array('id' => $entity->getId())));
        }

        return $this->render('SPJGameBundle:Challenge:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
    * Creates a form to create a Challenge entity.
    *
    * @param Challenge $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createCreateForm(Challenge $entity)
    {
        $form = $this->createForm(new ChallengeType(), $entity, array(
            'action' => $this->generateUrl('admin_challenge_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Challenge entity.
     *
     */
    public function newAction()
    {
        $entity = new Challenge();
        $form   = $this->createCreateForm($entity);

        return $this->render('SPJGameBundle:Challenge:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Challenge entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SPJGameBundle:Challenge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Challenge entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SPJGameBundle:Challenge:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        ));
    }

    /**
     * Displays a form to edit an existing Challenge entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SPJGameBundle:Challenge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Challenge entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('SPJGameBundle:Challenge:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Challenge entity.
    *
    * @param Challenge $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Challenge $entity)
    {
        $form = $this->createForm(new ChallengeType(), $entity, array(
            'action' => $this->generateUrl('admin_challenge_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Challenge entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('SPJGameBundle:Challenge')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Challenge entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_challenge_edit', array('id' => $id)));
        }

        return $this->render('SPJGameBundle:Challenge:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Challenge entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('SPJGameBundle:Challenge')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Challenge entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_challenge'));
    }

    /**
     * Creates a form to delete a Challenge entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_challenge_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}

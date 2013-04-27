<?php

namespace TMA\ConferenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use TMA\ConferenceBundle\Entity\Session;
use TMA\ConferenceBundle\Form\SessionType;
use JMS\SecurityExtraBundle\Annotation\Secure;

/**
 * Session controller.
 *
 * @Route("/session")
 */
class SessionController extends Controller
{
    /**
     * Lists all Session entities.
     *
     * @Route("/", name="session")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TMAConferenceBundle:Session')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Session entity.
     *
     * @Route("/", name="session_create")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("TMAConferenceBundle:Session:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Session();
        $form = $this->createForm(new SessionType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('session_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Session entity.
     *
     * @Route("/new", name="session_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Session();
        $form   = $this->createForm(new SessionType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Session entity.
     *
     * @Route("/{id}", name="session_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TMAConferenceBundle:Session')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Session entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Session entity.
     *
     * @Route("/{id}/edit", name="session_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TMAConferenceBundle:Session')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Session entity.');
        }

        $editForm = $this->createForm(new SessionType($entity->getTime()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Session entity.
     *
     * @Route("/{id}", name="session_update")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("PUT")
     * @Template("TMAConferenceBundle:Session:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TMAConferenceBundle:Session')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Session entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new SessionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('session_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Session entity.
     *
     * @Route("/{id}", name="session_delete")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TMAConferenceBundle:Session')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Session entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('session'));
    }

    /**
     * Creates a form to delete a Session entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
}

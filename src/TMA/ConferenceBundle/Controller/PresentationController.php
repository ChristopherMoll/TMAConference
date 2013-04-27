<?php

namespace TMA\ConferenceBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;
use TMA\ConferenceBundle\Entity\Presentation;
use TMA\ConferenceBundle\Form\PresentationType;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\HttpFoundation\BinaryFileResponse;


/**
 * Presentation controller.
 *
 * @Route("/presentation")
 */
class PresentationController extends Controller
{
    /**
     * Lists all Presentation entities.
     *
     * @Route("/", name="presentation")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('TMAConferenceBundle:Presentation')->findBy(array(), array('time' => 'ASC'));

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Creates a new Presentation entity.
     *
     * @Route("/", name="presentation_create")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("POST")
     * @Template("TMAConferenceBundle:Presentation:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Presentation();
        $form = $this->createForm(new PresentationType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('presentation_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Presentation entity.
     *
     * @Route("/new", name="presentation_new")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Presentation();
        $form   = $this->createForm(new PresentationType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Presentation entity.
     *
     * @Route("/{id}", name="presentation_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TMAConferenceBundle:Presentation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presentation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Presentation entity.
     *
     * @Route("/{id}/edit", name="presentation_edit")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TMAConferenceBundle:Presentation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presentation entity.');
        }

        $editForm = $this->createForm(new PresentationType($entity->getTime()), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Presentation entity.
     *
     * @Route("/{id}", name="presentation_update")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("PUT")
     * @Template("TMAConferenceBundle:Presentation:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TMAConferenceBundle:Presentation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presentation entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new PresentationType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('presentation_show', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Presentation entity.
     *
     * @Route("/{id}", name="presentation_delete")
     * @Secure(roles="ROLE_ADMIN")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('TMAConferenceBundle:Presentation')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Presentation entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('presentation'));
    }

    /**
     * Creates a form to delete a Presentation entity by id.
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

    /**
     * Displays a form to edit an existing Presentation entity.
     *
     * @Route("/{id}/file", name="presentation_file")
     * @Secure(roles="ROLE_USER")
     * @Method("GET")
     * @Template()
     */
    public function fileAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('TMAConferenceBundle:Presentation')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Presentation entity.');
        }

        $response = new BinaryFileResponse($entity->getWebPath());
        $response->headers->set('Content-Type','application/pdf');
        $response->setContentDisposition(ResponseHeaderBag::DISPOSITION_ATTACHMENT);
        return $response;
    }
}

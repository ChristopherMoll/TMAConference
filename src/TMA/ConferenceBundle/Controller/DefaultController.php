<?php

namespace TMA\ConferenceBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => "welcome");
    }

    /**
     * @Route("/agenda", name="agenda")
     * @Template()
     */
    public function agendaAction()
    {
        $em = $this->getDoctrine()->getManager();

        $sessions = $em->getRepository('TMAConferenceBundle:Session')->findBy(array(), array('time' => 'ASC'));

        return array(
            'sessions' => $sessions,
        );
    }
}

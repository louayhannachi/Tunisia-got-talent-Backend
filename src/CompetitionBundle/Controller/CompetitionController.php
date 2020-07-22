<?php

namespace CompetitionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CompetitionController extends Controller
{
    /**
     * Lists all competitions
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $competitions = $em->getRepository('CompetitionBundle:Competition')->findAll();

        $data = $this->get('jms_serializer')->serialize($competitions, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}

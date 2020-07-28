<?php

namespace EventBundle\Controller;

use EventBundle\Entity\CategoryEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Categoryevent controller.
 *
 */
class CategoryEventController extends Controller
{
    /**
     * Lists all categorieevent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $categorieevents = $em->getRepository('EventBundle:CategoryEvent')->findAll();
        $data = $this->get('jms_serializer')->serialize($categorieevents, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Creates a new categorieevent entity.
     *
     */
    public function newAction(Request $request)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );
        $categorieevent = new CategoryEvent();
        $categorieevent->setTitrecat($input["titrecat"]);

        $em = $this->getDoctrine()->getManager();
        $em->persist($categorieevent);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($categorieevent, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Finds and displays a categorieevent entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('EventBundle:CategoryEvent')->findOneBy(["id"=>$id]);

        $data = $this->get('jms_serializer')->serialize($category, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Displays a form to edit an existing categorieevent entity.
     *
     */
    public function editAction(Request $request)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );
        $em = $this->getDoctrine()->getManager();

        $category = $em->getRepository('EventBundle:CategoryEvent')->findOneBy(["id"=>$input["id"]]);
        $category->setTitrecat($input["titrecat"]);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($category, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Deletes a categorieevent entity.
     *
     */
    public function deleteAction(Request $request, CategoryEvent $categorieevent)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($categorieevent);
        $em->flush();
        $data = $this->get('jms_serializer')->serialize($categorieevent->getTitrecat() . " is deleted", 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}

<?php

namespace EventBundle\Controller;

use DateTime;
use EventBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use EventBundle\Repository\EvenementRepository;

/**
 * Evenement controller.
 *
 */
class EvenementController extends Controller
{
    /**
     * Lists all evenement entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $evenements = $em->getRepository('EventBundle:Evenement')->findAll();

        $data = $this->get('jms_serializer')->serialize($evenements, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /**
     * search all evenement entities.
     *
     */
    public function searchAction()
    {
        $em = $this->getDoctrine()->getManager();
        $cat = $em->getRepository('EventBundle:CategoryEvent')->findOneBy(array("titrecat"=>$_GET["search"]));
        $evenements = $em->getRepository('EventBundle:Evenement')->findBy(array("idcat" => $cat));

        $data = $this->get('jms_serializer')->serialize($evenements, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /**
     * Creates a new evenement entity.
     *
     */
    public function newAction(Request $request)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );
        $em = $this->getDoctrine()->getManager();

        $cat = $em->getRepository('EventBundle:CategoryEvent')->findOneBy(['id' => $input['idcat']]);

        $evenement = new Evenement();
        $evenement->setTitre($input['titre']);
        $evenement->setDescription($input['description']);
        $evenement->setNbparticipant($input['nbparticipant']);
        $evenement->setDate($input['date']);
        $evenement->setIduser(null);
        $evenement->setIdcat($cat);
        $em->persist($evenement);
        $em->flush();


        $data = $this->get('jms_serializer')->serialize($evenement, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /**
     * Displays a form to edit an existing evenement entity.
     *
     */
    public function editAction(Request $request)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );
        $em = $this->getDoctrine()->getManager();

        $evenement = $em->getRepository('EventBundle:Evenement')->findOneBy(["id"=>$input["id"]]);
        $cat = $em->getRepository('EventBundle:CategoryEvent')->findOneBy(["id"=>$input["idcat"]["id"]]);

        $evenement->setTitre($input['titre']);
        $evenement->setDescription($input['description']);
        $evenement->setNbparticipant($input['nbparticipant']);
        $evenement->setDate($input['date']);
        $evenement->setIduser(null);
        $evenement->setIdcat($cat);
        $em->flush();


        $data = $this->get('jms_serializer')->serialize($evenement, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Finds and displays a evenement entity.
     *
     */
    public function showAction(Evenement $evenement)
    {
            $data = $this->get('jms_serializer')->serialize($evenement, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

    }


    /**
     * Deletes a evenement entity.
     *
     */
    public function deleteAction(Request $request, Evenement $evenement)
    {

        $em = $this->getDoctrine()->getManager();
        $em->remove($evenement);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize("The event is deleted", 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}

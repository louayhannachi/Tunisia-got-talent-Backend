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

        $user = $em->getRepository('TalentBundle:User')->find($input['iduser']);
        $cat = $em->getRepository('EventBundle:CategoryEvent')->find($input['idcat']);

        $evenement = new Evenement();
        $evenement->setTitre($input['titre']);
        $evenement->setDescription($input['description']);
        $evenement->setNbparticipant($input['nbparticipant']);
        $evenement->setDate(new DateTime($input['date']));
        $evenement->setIduser($user);
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
    public function editAction(Request $request, Evenement $evenement)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );
        $em = $this->getDoctrine()->getManager();

        $user = $em->getRepository('TalentBundle:User')->find($input['iduser']);
        $cat = $em->getRepository('EventBundle:CategoryEvent')->find($input['idcat']);

        $evenement->setTitre($input['titre']);
        $evenement->setDescription($input['description']);
        $evenement->setNbparticipant($input['nbparticipant']);
        $evenement->setDate(new DateTime($input['date']));
        $evenement->setIduser($user);
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
        if ($evenement->getDate() > new DateTime()) {
            $data = $this->get('jms_serializer')->serialize($evenement, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        } else {
            $data = $this->get('jms_serializer')->serialize("Depassé", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
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

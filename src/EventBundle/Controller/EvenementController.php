<?php

namespace EventBundle\Controller;

use DateTime;
use EventBundle\Entity\Evenement;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * Creates a new evenement entity.
     *
     */
    public function newAction(Request $request)
    {
        $evenement = new Evenement();
        $evenement->setTitre($_GET["titre"]);
        $evenement->setDescription($_GET["description"]);
        $evenement->setNbparticipant($_GET["nbparticipant"]);
        $evenement->setDate(new DateTime($_GET["date"]));

        $em = $this->getDoctrine()->getManager();
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
        $evenement->setTitre($_GET["titre"]);
        $evenement->setDescription($_GET["description"]);
        $evenement->setNbparticipant($_GET["nbparticipant"]);
        $evenement->setDate(new DateTime($_GET["date"]));

        $em = $this->getDoctrine()->getManager()->flush();


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
        if ($evenement->getDate()>new DateTime()){
        $data = $this->get('jms_serializer')->serialize($evenement, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        }else{
            $data = $this->get('jms_serializer')->serialize("Depassé", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }


    /**
     * Creates a form to delete a evenement entity.
     *
     * @param Evenement $evenement The evenement entity
     *
     * @return Form The form
     */
    private function createDeleteForm(Evenement $evenement)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('evenement_delete', array('id' => $evenement->getId())))
            ->setMethod('DELETE')
            ->getForm();
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

        $data = $this->get('jms_serializer')->serialize($evenement, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function participerAction(Evenement $evenement)
    {
        if ($evenement->getNbparticipant()>0){
        $evenement->setNbparticipant($evenement->getNbparticipant()-1);

        $this->getDoctrine()->getManager()->flush();
            $data = $this->get('jms_serializer')->serialize($evenement, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

        }else{
            $data = $this->get('jms_serializer')->serialize("Cannot Participate", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

        }

    }
}

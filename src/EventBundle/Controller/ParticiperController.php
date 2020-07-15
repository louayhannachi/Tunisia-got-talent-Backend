<?php

namespace EventBundle\Controller;

use DateTime;
use EventBundle\Entity\Evenement;
use EventBundle\Entity\Participer;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Participer controller.
 *
 */
class ParticiperController extends Controller
{
    /**
     * Lists all participer entities.
     *
     */
    public function indexAction($idevent)
    {
        $em = $this->getDoctrine()->getManager();

        $participers = $em->getRepository('EventBundle:Participer')->findBy(["idevent" => $idevent]);

        $data = $this->get('jms_serializer')->serialize($participers, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    /**
     * Finds and displays a participer entity.
     *
     */
    public function showAction(Request $request)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );

        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('EventBundle:Evenement')->find($input["idevent"]);
        $user = $em->getRepository('TalentBundle:User')->find($input["iduser"]);
        $participer = $em->getRepository('EventBundle:Participer')->findOneBy(array("idevent" => $evenement, "iduser" => $user));

        $data = $this->get('jms_serializer')->serialize($participer, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Deletes a participer entity.
     *
     */
    public function deleteAction(Request $request)
    {

        $input = json_decode(
            $request->getContent(),
            true
        );
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('EventBundle:Evenement')->find($input["idevent"]);
        $user = $em->getRepository('TalentBundle:User')->find($input["iduser"]);
        $participer = $em->getRepository('EventBundle:Participer')->findOneBy(array("idevent" => $evenement, "iduser" => $user));

        if ($evenement->getDate() > new DateTime("+1 days") and $participer != NULL) {
            $evenement->setNbparticipant($evenement->getNbparticipant() + 1);
            $em->remove($participer);
            $em->flush();
            $data = $this->get('jms_serializer')->serialize("your participation is deleted", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

        } else {
            $data = $this->get('jms_serializer')->serialize("Cannot", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

        }
    }

    /**
     * Creates a new participer entity.
     *
     */
    public function newAction(Request $request)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('EventBundle:Evenement')->find($input["idevent"]);
        $user = $em->getRepository('TalentBundle:User')->find($input["iduser"]);
        $participer = $em->getRepository('EventBundle:Participer')->findOneBy(array("idevent" => $evenement, "iduser" => $user));

        if ($evenement->getDate() > new DateTime() and $evenement->getNbparticipant() > 0 and $participer == NULL) {
            $evenement->setNbparticipant($evenement->getNbparticipant() - 1);

            $part = new Participer();
            $part->setIdevent($evenement);
            $part->setIduser($user);
            $em->persist($part);
            $em->flush();
            $data = $this->get('jms_serializer')->serialize($part, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

        } else {
            $data = $this->get('jms_serializer')->serialize("Cannot Participate", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

        }
    }
}

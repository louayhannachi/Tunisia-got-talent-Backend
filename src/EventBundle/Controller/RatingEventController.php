<?php

namespace EventBundle\Controller;

use DateTime;
use EventBundle\Entity\RatingEvent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

/**
 * Ratingevent controller.
 *
 */
class RatingEventController extends Controller
{
    /**
     * Lists all ratingEvent entities.
     *
     */
    public function indexAction($idevent)
    {
        $em = $this->getDoctrine()->getManager();

        $ratingEvents = $em->getRepository('EventBundle:RatingEvent')->findBy(["idevent" => $idevent]);
        $sum = 0;
        foreach ($ratingEvents as $re) {
            $sum = $sum + $re->getValueEvent();
        }
        if (count($ratingEvents) == 0) {
            $data = $this->get('jms_serializer')->serialize("No Rating", 'json');
        } else {
            $data = $this->get('jms_serializer')->serialize($sum / count($ratingEvents), 'json');
        }
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Creates a new ratingEvent entity.
     *
     */
    public
    function newAction(Request $request)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );
        $em = $this->getDoctrine()->getManager();
        $evenement = $em->getRepository('EventBundle:Evenement')->find($input["idevent"]);
        $user = $em->getRepository('TalentBundle:User')->find($input["iduser"]);
        $ratingEvent = $em->getRepository('EventBundle:RatingEvent')->findOneBy(array("idevent" => $evenement, "iduser" => $user));
        if ($ratingEvent == NULL) {
            if ($evenement->getDate() < new DateTime()) {
                $rating = new RatingEvent();
                $rating->setIduser($user);
                $rating->setIdevent($evenement);
                $rating->setValueEvent($input["value"]);
                $em->persist($rating);
                $em->flush();
                $data = $this->get('jms_serializer')->serialize($rating, 'json');
                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->headers->set('Access-Control-Allow-Origin', '*');
                return $response;
            } else {
                $data = $this->get('jms_serializer')->serialize("Error Date", 'json');
                $response = new Response($data);
                $response->headers->set('Content-Type', 'application/json');
                $response->headers->set('Access-Control-Allow-Origin', '*');
                return $response;
            }
        } else {
            $ratingEvent->setValueEvent($input["value"]);
            $em->flush();
            $data = $this->get('jms_serializer')->serialize($ratingEvent, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

    }

    /**
     * Finds and displays a ratingEvent entity.
     *
     */
    public
    function showAction(Request $request)
    {
        $input = json_decode(
            $request->getContent(),
            true
        );
        $em = $this->getDoctrine()->getManager();


        $rating = $em->getRepository('EventBundle:RatingEvent')->findOneBy(["iduser" => $input['iduser'], "idevent" => $input['idevent']]);
        $data = $this->get('jms_serializer')->serialize($rating, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

}

<?php

namespace EventBundle\Controller;

use EventBundle\Entity\Favoris;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Favori controller.
 *
 */
class FavorisController extends Controller
{
    /**
     * Lists all favori entities.
     *
     */
    public function indexAction($iduser)
    {
        $em = $this->getDoctrine()->getManager();

        $favoris = $em->getRepository('EventBundle:Favoris')->findBy(["iduser" => $iduser]);

        $data = $this->get('jms_serializer')->serialize($favoris, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Finds and displays a favori entity.
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
        $favoris = $em->getRepository('EventBundle:Favoris')->findOneBy(array("idevent" => $evenement, "iduser" => $user));

        $data = $this->get('jms_serializer')->serialize($favoris, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Deletes a favori entity.
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
        $favoris = $em->getRepository('EventBundle:Favoris')->findOneBy(array("idevent" => $evenement, "iduser" => $user));

        if ($favoris != null) {
            $em->remove($favoris);
            $em->flush();
            $data = $this->get('jms_serializer')->serialize("The event is deleted from your list", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

        } else {
            $data = $this->get('jms_serializer')->serialize("Not Found", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

    /**
     * Creates a new favori entity.
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
        $favoris = $em->getRepository('EventBundle:Favoris')->findOneBy(array("idevent" => $evenement, "iduser" => $user));

        if ($favoris == NULL) {
            $favori = new Favoris();
            $favori->setIduser($user);
            $favori->setIdevent($evenement);
            $em->persist($favori);
            $em->flush();
            $data = $this->get('jms_serializer')->serialize($favori, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        } else {
            $data = $this->get('jms_serializer')->serialize($favoris, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }

    }
}

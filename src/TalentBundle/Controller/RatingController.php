<?php

namespace TalentBundle\Controller;

use TalentBundle\Entity\Rating;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Rating controller.
 *
 */
class RatingController extends Controller
{
    /**
     * Lists all rating entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $ratings = $em->getRepository('TalentBundle:Rating')->findAll();

        $data = $this->get('jms_serializer')->serialize($ratings, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function getByProfilIdAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('TalentBundle:Profil')->find($id);
        $ratings = $em->getRepository('TalentBundle:Rating')->findBy(["profil"=>$profils]);

        $data = $this->get('jms_serializer')->serialize($ratings, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Creates a new rating entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rating = new Rating();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $parametersAsArray['iduser']['id']]);
        $profil =$em->getRepository('TalentBundle:Profil')->findOneBy(['id' => $parametersAsArray['profil']['id']]);

        $rating->setRate($parametersAsArray['rate']);
        $rating->setIduser($user);
        $rating->setProfil($profil);


        $em->persist($rating);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($rating, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Displays a form to edit an existing rating entity.
     *
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $rating = $em->getRepository('TalentBundle:Rating')->findOneBy(['id' => $parametersAsArray['id']]);

        $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $parametersAsArray['iduser']['id']]);
        $profil =$em->getRepository('TalentBundle:Profil')->findOneBy(['id' => $parametersAsArray['profil']['id']]);

        $rating->setRate($parametersAsArray['rate']);
        $rating->setIduser($user);
        $rating->setProfil($profil);


        $em->persist($rating);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($rating, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Deletes a rating entity.
     *
     */
    public function deleteAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $rating = $em->getRepository('TalentBundle:Rating')->find($id);
        $em->remove($rating);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize("Delete with success", 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
}

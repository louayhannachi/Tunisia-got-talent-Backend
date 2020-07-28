<?php

namespace CompetitionBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CompetitionBundle\Entity\Competition;
use CompetitionBundle\Entity\CompetitionParticipation;
use CompetitionBundle\Entity\CompetitionRating;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use TalentBundle\Entity\User;


class CompetitionController extends Controller
{
    /**
     * Lists all competitions
     *
     */
    public function getAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $competitions = $em->getRepository('CompetitionBundle:Competition')->findAll();

        $data = $this->get('jms_serializer')->serialize($competitions, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function showAction($compId)
    {
        $competition = $this->getDoctrine()
            ->getRepository(Competition::class)
            ->find($compId);

        if (!$competition) {
            throw $this->createNotFoundException(
                'No product found for id '.$compId
            );
        }

        $data = $this->get('jms_serializer')->serialize($competition, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Displays a form to edit an existing competition entity.
     *
     */
    public function editAction(Request $request, Competition $competition)
    {
        $em = $this->getDoctrine()->getManager();

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $competition = $em->getRepository('CompetitionBundle:Competition')->findOneBy(['id' => $parametersAsArray['id']]);

        $competition->setNom($parametersAsArray['nom']);
        $competition->setCompType($parametersAsArray['competition_type']);
        $competition->setDescription($parametersAsArray['description']);
        $competition->setNbMaxParticipant($parametersAsArray['nb_max_participant']);
        $competition->setDateDebut($parametersAsArray['date_deb']);
        $competition->setDateFin($parametersAsArray['date_fin']);


        $em->persist($competition);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($competition, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Deletes a competition entity.
     *
     */
    public function deleteAction(Request $request, Competition $competition)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($competition);
        $em->flush();
        $data = $this->get('jms_serializer')->serialize($competition->getNom() . " is deleted", 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


    /** 
     * TEST
     * Create MOCK Competition
     */
    public function newMockAction()
    {
        $em = $this->getDoctrine()->getManager();

        $competition = new Competition();
        $competition->setNom('Performance 2020');

        $competition->setDescription('Lorem ipsum dolor sit amet, consectetur adipiscing elit.
         Aliquam a vehicula nisl. Ut tempor nibh eros, eget blandit erat pulvinar porta.
          Vestibulum erat libero');

        $competition->setDateDebut('2020-06-15');

        $competition->setDateFin('2020-06-30');

        $competition->setNbParticipant('50');

        $competition->setNbMaxParticipant('50');
        
        $competition->setCompType('Performance de spectacle');
    
        // tells Doctrine you want to (eventually) save the Competition (no queries yet)
        $em->persist($competition);
    
        // actually executes the queries (i.e. the INSERT query)
        $em->flush();
    
        return new Response('Saved new Competition with id '.$competition->getId());
    }


    /**
     * Creates a new competition entity.
     *
     */
    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $competition = new Competition();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $competition->setNom($parametersAsArray['nom']);
        $competition->setCompType($parametersAsArray['competition_type']);
        $competition->setDescription($parametersAsArray['description']);
        $competition->setNbMaxParticipant($parametersAsArray['nb_max_participant']);
        $competition->setDateDebut($parametersAsArray['date_deb']);
        $competition->setDateFin($parametersAsArray['date_fin']);
        $competition->setNbParticipant(0);

        /** TO DO FOREIGN KEY */
        // $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $parametersAsArray['userId']]);
        $competition->setUserId($parametersAsArray['userId']);


        $em->persist($competition);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($competition, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function participateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $participation = new CompetitionParticipation();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $participation->setIdComp($parametersAsArray['id']);
        $participation->setIdUser($parametersAsArray['connectedUserId']);


        $em->persist($participation);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($participation, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function rateAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rating = new CompetitionRating();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $rating->setIdComp($parametersAsArray['compId']);
        $rating->setIdUser($parametersAsArray['connectedUserId']);
        $rating->setRateValue($parametersAsArray['rateValue']);


        $em->persist($rating);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($rating, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function getParticipationsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $compParticipations = $em->getRepository('CompetitionBundle:CompetitionParticipation')->findAll();

        $data = $this->get('jms_serializer')->serialize($compParticipations, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function getRatingsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $compRatings = $em->getRepository('CompetitionBundle:CompetitionRating')->findAll();

        $data = $this->get('jms_serializer')->serialize($compRatings, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

}

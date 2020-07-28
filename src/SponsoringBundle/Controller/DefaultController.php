<?php

namespace SponsoringBundle\Controller;

use SponsoringBundle\Entity\Entreprise;
use SponsoringBundle\Entity\Sponsorise;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('SponsoringBundle:Default:index.html.twig');
    }


    public function addEntrepriseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $entreprise = new Entreprise();
        $entreprise->setNom($parametersAsArray['name']);
        $entreprise->setLieux($parametersAsArray['place']);
        $entreprise->setEmail($parametersAsArray['email']);
        $entreprise->setSiteOfficiel($parametersAsArray['site']);
        $entreprise->setNbrEmploye($parametersAsArray['nbEmp']);
        $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $parametersAsArray['id_user']]);

        $entreprise->setIduser($user);
        $s = $request->get('date_creation');
        $date = date_create_from_format('Y-m-d', $s);
        $entreprise->setDateCreation(new \DateTime());
        $em->persist($entreprise);
        $em->flush();


        $data = $this->get('jms_serializer')->serialize($entreprise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    public function modifierEntrepriseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $entreprise = $em->getRepository('SponsoringBundle:Entreprise')->findOneBy(['id' => $parametersAsArray['id']]);

        $entreprise->setNom($parametersAsArray['name']);
        $entreprise->setLieux($parametersAsArray['place']);
        $entreprise->setEmail($parametersAsArray['email']);
        $entreprise->setSiteOfficiel($parametersAsArray['site']);
        $entreprise->setNbrEmploye($parametersAsArray['nbEmp']);

        $em->persist($entreprise);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($entreprise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    public function supprimerEntrepriseAction(Request $request, $id)
    {

        $em = $this->getDoctrine()->getManager();
        $entreprise = $em->getRepository('SponsoringBundle:Entreprise')->find($id);

        $em->remove($entreprise);
        $em->flush();



        $data = $this->get('jms_serializer')->serialize('delet succ', 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }
    public function afficherEntrepriseAction()
    {
        $entreprises = $this->getDoctrine()->getManager()
            ->getRepository('SponsoringBundle:Entreprise')
            ->findAll();

        $data = $this->get('jms_serializer')->serialize($entreprises, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function afficherEntrepriseByEventAction(Request $request, $id)
    {   $em = $this->getDoctrine()->getManager();
        $entreprise =$em->getRepository('SponsoringBundle:Entreprise')->findOneBy(['id' => $id]);

        $data = $this->get('jms_serializer')->serialize($entreprise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function addSponsoriseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $sponsorise = new Sponsorise();
        $sponsorise->setType($request->get('type'));
        $s = $request->get('date_sp');
        $date = date_create_from_format('Y-m-d', $s);
        $sponsorise->setDateSp($date);

        $s = $request->get('entreprise');
        $id = (int)$s;
        $entreprise = $this->getDoctrine()->getManager()
            ->getRepository('SponsoringBundle:Entreprise')
            ->find($id);
        $sponsorise->setEntreprise($entreprise);

        $em->persist($sponsorise);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($entreprise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    public function modifierSponsoriseAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $idSponsorise = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $sponsorise  =   $this->getDoctrine()->getRepository('SponsoringBundle:Sponsorise')->find($idSponsorise);
        $type = $request->get('type');
        $s = $request->get('date_sp');
        $date = date_create_from_format('Y-m-d', $s);
        $sponsorise->setDateSp($date);
        $s = $request->get('entreprise');
        $id = (int)$s;
        $entreprise = $this->getDoctrine()->getManager()
            ->getRepository('SponsoringBundle:Entreprise')
            ->find($id);
        $sponsorise->setType($type);
        $sponsorise->setEntreprise($entreprise);

        $em->persist($sponsorise);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($sponsorise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }
    public function supprimerSponsoriseAction(Request $request)
    {


        $idSponsorise = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entreprise  =   $this->getDoctrine()->getRepository('SponsoringBundle:Sponsorise')->find($idSponsorise);
        $em->remove($entreprise);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($entreprise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    public function afficherSponsoriseAction()//lister les pieces defectueuses non reserver (pour le reparateur)
    {
        $sponsorise = $this->getDoctrine()->getManager()
            ->getRepository('SponsoringBundle:Sponsorise')
            ->findAll();

        $data = $this->get('jms_serializer')->serialize($sponsorise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function afficherSponsoriseByUserAction(Request $request)
    {
        $idUser = $request->get('idUser');
        $entreprises = $this->getDoctrine()->getManager()
            ->getRepository('SponsoringBundle:Sponsorise')
            ->findByIduser($idUser);

        $data = $this->get('jms_serializer')->serialize($entreprises, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function searchAction(Request $request)
    {
        $nom = $request->get('nom');
        $entreprise = $this->getDoctrine()->getRepository('SponsoringBundle:Entreprise')->
        search_by_nom($nom);

        $data = $this->get('jms_serializer')->serialize($entreprise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    public function sortAction()
    {
        $sponsorise = $this->getDoctrine()->getRepository('SponsoringBundle:Sponsorise')
            ->sort_by_Date();

        $data = $this->get('jms_serializer')->serialize($sponsorise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }

    public function getDateEntrepriseAction(Request $request)
    {


        $idEntreprise = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entreprise  =   $this->getDoctrine()->getRepository('SponsoringBundle:Entreprise')->find($idEntreprise);

        $date = $entreprise->getDateCreation();
        $result = $date->format('Y-m-d');

        $array_merged = [
            "DateCreation"=>$result,
        ];
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($array_merged);
        return new JsonResponse($formatted);

    }

    public function getDateSponsoriseAction(Request $request)
    {


        $idSponsorise = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $sponsorise  =   $this->getDoctrine()->getRepository('SponsoringBundle:Sponsorise')->find($idSponsorise);

        $date = $sponsorise->getDateSp();
        $result = $date->format('Y-m-d');

        $array_merged = [
            "DateSp"=>$result,
        ];

        $data = $this->get('jms_serializer')->serialize($sponsorise, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;

    }
}

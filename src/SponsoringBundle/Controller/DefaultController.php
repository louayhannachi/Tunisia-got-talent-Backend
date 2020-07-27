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
        $entreprise = new Entreprise();
        $entreprise->setNom($request->get('nom'));
        $entreprise->setLieux($request->get('lieux'));
        $entreprise->setEmail($request->get('email'));
        $entreprise->setSiteOfficiel($request->get('site_officiel'));
        $entreprise->setNbrEmploye($request->get('nbr_employe'));

        $s = $request->get('date_creation');
        $date = date_create_from_format('Y-m-d', $s);
        $entreprise->setDateCreation($date);

        $em->persist($entreprise);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($entreprise);
        return new JsonResponse($formatted);

    }

    public function modifierEntrepriseAction(Request $request)
    {


        $idEntreprise = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entreprise  =   $this->getDoctrine()->getRepository('SponsoringBundle:Entreprise')->find($idEntreprise);

        $nom = $request->get('nom');
        $lieux = $request->get('lieux');
        $email = $request->get('email');
        $site_officiel = $request->get('site_officiel');
        $nbr_employe = $request->get('nbr_employe');
        $entreprise->setNom($nom);
        $entreprise->setLieux($lieux);
        $entreprise->setEmail($email);
        $entreprise->setSiteOfficiel($site_officiel);
        $entreprise->setNbrEmploye($nbr_employe);

        $em->persist($entreprise);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("entreprise modifie");
        return new JsonResponse($formatted);

    }

    public function supprimerEntrepriseAction(Request $request)
    {


        $idEntreprise = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entreprise  =   $this->getDoctrine()->getRepository('SponsoringBundle:Entreprise')->find($idEntreprise);
        $em->remove($entreprise);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("entreprise supprime");
        return new JsonResponse($formatted);

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

    public function afficherEntrepriseByUserAction(Request $request)
    {
        $idUser = $request->get('idUser');
        $entreprises = $this->getDoctrine()->getManager()
            ->getRepository('SponsoringBundle:Entreprise')
            ->findByIduser($idUser);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($entreprises);
        return new JsonResponse($formatted);
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
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($sponsorise);
        return new JsonResponse($formatted);

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
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($sponsorise);
        return new JsonResponse($formatted);

    }
    public function supprimerSponsoriseAction(Request $request)
    {


        $idSponsorise = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $entreprise  =   $this->getDoctrine()->getRepository('SponsoringBundle:Sponsorise')->find($idSponsorise);
        $em->remove($entreprise);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize("Sponsorise supprime");
        return new JsonResponse($formatted);

    }

    public function afficherSponsoriseAction()//lister les pieces defectueuses non reserver (pour le reparateur)
    {
        $sponsorise = $this->getDoctrine()->getManager()
            ->getRepository('SponsoringBundle:Sponsorise')
            ->findAll();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($sponsorise);
        return new JsonResponse($formatted);
    }

    public function afficherSponsoriseByUserAction(Request $request)
    {
        $idUser = $request->get('idUser');
        $entreprises = $this->getDoctrine()->getManager()
            ->getRepository('SponsoringBundle:Sponsorise')
            ->findByIduser($idUser);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($entreprises);
        return new JsonResponse($formatted);
    }

    public function searchAction(Request $request)
    {
        $nom = $request->get('nom');
        $entreprise = $this->getDoctrine()->getRepository('SponsoringBundle:Entreprise')->search_by_nom($nom);
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($entreprise);
        return new JsonResponse($formatted);

    }

    public function sortAction()
    {
        $sponsorise = $this->getDoctrine()->getRepository('SponsoringBundle:Sponsorise')->sort_by_Date();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($sponsorise);
        return new JsonResponse($formatted);

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
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($array_merged);
        return new JsonResponse($formatted);

    }
}

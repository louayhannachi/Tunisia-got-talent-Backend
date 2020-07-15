<?php

namespace TalentBundle\Controller;

use TalentBundle\Entity\Profil;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Response;
use TalentBundle\Entity\User;

/**
 * Profil controller.
 *
 */
class ProfilController extends Controller
{
    /**
     * Lists all profil entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('TalentBundle:Profil')->findAll();
        //$rating = $em->getRepository('TalentBundle:Rating')->findAll();
        //$likes = $em->getRepository('TalentBundle:Likes')->findAll();
        //$items = array("profils" => $profils,"rating" => $rating,"likes" => $likes);
        $data = $this->get('jms_serializer')->serialize($profils, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    public function relatedToProfileAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $profils = $em->getRepository('TalentBundle:Profil')->find($id);
        $ratings = $em->getRepository('TalentBundle:Rating')->findBy(["profil"=>$profils]);
        $comments = $em->getRepository('TalentBundle:Comment')->findBy(["profil"=>$profils]);
        $likes = $em->getRepository('TalentBundle:Likes')->findBy(["comment"=>$comments]);

        $items = array("profils" => $profils,"ratings" => $ratings,"comment"=>$comments,"likes" => $likes);
        $data = $this->get('jms_serializer')->serialize($items, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Deletes a profil entity.
     *
     */
    public function deleteAction(Request $request, int $id)
    {
        $em = $this->getDoctrine()->getManager();
        $profil = $em->getRepository('TalentBundle:Profil')->find($id);
        $em->remove($profil);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize("Delete with success", 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    /**
     * Creates a new profil entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $profil = new Profil();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $profil->setAddress($parametersAsArray['address']);
        $profil->setGovernorate($parametersAsArray['governorate']);
        $profil->setAge($parametersAsArray['age']);
        $profil->setCategory($parametersAsArray['category']);
        $profil->setTelephone($parametersAsArray['telephone']);
        $profil->setTalent($parametersAsArray['talent']);
        $profil->setDescription($parametersAsArray['description']);
        $profil->setVideo($parametersAsArray['video']);
        $profil->setPhoto($parametersAsArray['photo']);
        $profil->setBanned($parametersAsArray['banned']);
        $profil->setNbbanners($parametersAsArray['nbbanners']);
        //$profil->setBanneduntil($parametersAsArray['banneduntil']);
        $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $parametersAsArray['iduser']['id']]);
        $profil->setIduser($user);


        $em->persist($profil);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($profil, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    /**
     * Displays a form to edit an existing profil entity.
     *
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $profil = $em->getRepository('TalentBundle:Profil')->findOneBy(['id' => $parametersAsArray['id']]);
        $profil->setAddress($parametersAsArray['address']);
        $profil->setGovernorate($parametersAsArray['governorate']);
        $profil->setAge($parametersAsArray['age']);
        $profil->setCategory($parametersAsArray['category']);
        $profil->setTelephone($parametersAsArray['telephone']);
        $profil->setTalent($parametersAsArray['talent']);
        $profil->setDescription($parametersAsArray['description']);
        $profil->setVideo($parametersAsArray['video']);
        $profil->setPhoto($parametersAsArray['photo']);
        $profil->setBanned($parametersAsArray['banned']);
        $profil->setNbbanners($parametersAsArray['nbbanners']);
        //$profil->setBanneduntil($parametersAsArray['banneduntil']);


        $em->persist($profil);
        $em->flush();

        $data = $this->get('jms_serializer')->serialize($profil, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function searchAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }

        $user =$em->getRepository('TalentBundle:User')->findOneBy(['username' => $parametersAsArray['username']]);
        if ($parametersAsArray['governorate'] and $user and $parametersAsArray['category']) {
            $profils = $em->getRepository('TalentBundle:Profil')->findBy(['governorate'=> $parametersAsArray['governorate'],'category' => $parametersAsArray['category'], 'iduser' =>$user]);
        } elseif ($parametersAsArray['governorate'] and $parametersAsArray['category']) {
            $profils = $em->getRepository('TalentBundle:Profil')->findBy(['governorate'=> $parametersAsArray['governorate'], 'category'=> $parametersAsArray['category']]);
        } elseif ($user and $parametersAsArray['category']) {
            $profils = $em->getRepository('TalentBundle:Profil')->findBy(['category'=> $parametersAsArray['category'], 'iduser' =>$user]);
        } elseif ($user and $parametersAsArray['governorate']){
            $profils = $em->getRepository('TalentBundle:Profil')->findBy(['governorate' => $parametersAsArray['governorate'], 'iduser' =>$user]);
        } elseif ($user) {
            $profils = $em->getRepository('TalentBundle:Profil')->findBy(['iduser' =>$user]);
        } elseif($parametersAsArray['governorate']) {
            $profils = $em->getRepository('TalentBundle:Profil')->findBy(['governorate' => $parametersAsArray['governorate']]);
        } elseif($parametersAsArray['category']){
            $profils = $em->getRepository('TalentBundle:Profil')->findBy(['category' => $parametersAsArray['category']]);
        }



        $operator = '%';
        //$profils = $em->getRepository('TalentBundle:Profil')->createQueryBuilder('profil')
        //    ->where('profil.category LIKE :category')
        //    ->setParameter('category', $operator.$parametersAsArray['category'].$operator)
        //    ->getQuery()
        //    ->getResult();
        $data = $this->get('jms_serializer')->serialize($profils, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


}

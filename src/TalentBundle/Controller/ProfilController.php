<?php

namespace TalentBundle\Controller;

use TalentBundle\Entity\count;
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
        $comments = $em->getRepository('TalentBundle:Comment')->findBy(["profils"=>$profils]);
        $likes = $em->getRepository('TalentBundle:Likes')->findBy(["comment"=>$comments]);

        $items = array("profils" => $profils,"ratings" => $ratings,"comment"=>$comments,"likes" => $likes);
        $data = $this->get('jms_serializer')->serialize($items, 'json');

        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function profilByUSerIDAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $id]);
        $profil = $em->getRepository('TalentBundle:Profil')->findOneBy(['iduser' => $user]);

        if($profil){
            $data = $this->get('jms_serializer')->serialize($profil, 'json');
        } else {
            $data = $this->get('jms_serializer')->serialize(null, 'json');
        }
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
        $profil->setBanned(0);
        $profil->setNbbanners(0);
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
        $profil->setBanned(0);
        $profil->setNbbanners(0);
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

    public function getNumberOfLikesPerProfilAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $profils = $em->getRepository('TalentBundle:Profil')->findAll();
        $tab = array();
        foreach($profils as $p) {
            $number = 0;
            $comments = $em->getRepository('TalentBundle:Comment')->findBy(['profils'=>$p->getId()]);
            foreach($comments as $c) {
                $number = $number + $c->getNblike();
            };
            $count = new count();
            $count->setNbslike($number);
            $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $p->getIduser()]);
            $count->setUsername($user->getUsernameCanonical());
            array_push($tab,$count);
        };
        $data = $this->get('jms_serializer')->serialize($tab, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function getNumberOfCommentPerProfilAction(Request $request){
        $em = $this->getDoctrine()->getManager();
        $profils = $em->getRepository('TalentBundle:Profil')->findAll();
        $tab = array();
        foreach($profils as $p) {
            $number = 0;
            $comments = $em->getRepository('TalentBundle:Comment')->findBy(['profils'=>$p->getId()]);
            foreach($comments as $c) {
                $number ++;
            };
            $count = new count();
            $count->setNbslike($number);
            $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $p->getIduser()]);
            $count->setUsername($user->getUsernameCanonical());
            array_push($tab,$count);
        };
        $data = $this->get('jms_serializer')->serialize($tab, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function getRatingStatAction(){
        $em = $this->getDoctrine()->getManager();
        $profils = $em->getRepository('TalentBundle:Profil')->findAll();
        $tab = array();
        foreach($profils as $p) {
            $rate = 0;
            $ratings = $em->getRepository('TalentBundle:Rating')->findBy(['profil'=>$p->getId()]);
            $count = new count();
            $size = sizeof($ratings);

            if ($size> 0){
                foreach($ratings as $c) {
                    $rate = $rate + $c->getRate();
                };
                $count->setNbslike($rate / $size);
            } else {
                $count->setNbslike(0);
            }

            $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $p->getIduser()]);
            $count->setUsername($user->getUsernameCanonical());
            array_push($tab,$count);
        };
        $data = $this->get('jms_serializer')->serialize($tab, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }



}

<?php

namespace TalentBundle\Controller;

use TalentBundle\Entity\Likes;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Like controller.
 *
 */
class LikesController extends Controller
{

    public function likeAction(Request $request, int $iduser, int $idcomment )
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TalentBundle:User')->findOneBy(['id' => $iduser]);
        $comment = $em->getRepository('TalentBundle:Comment')->findOneBy(['id' => $idcomment]);

        $like = $em->getRepository('TalentBundle:Likes')->findOneBy(['iduser' => $user, 'comment' => $comment]);

        if ($like) {
            $em->remove($like);
            $em->flush();

            $comment =$em->getRepository('TalentBundle:Comment')->findOneBy(['id' => $like->getComment()->getId()]);
            $comment->setNblike($comment->getNblike()-1);
            $em->persist($comment);
            $em->flush();

            $data = $this->get('jms_serializer')->serialize("Unlike !", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        } else {
            $like = new Likes();
            $like->setIduser($user);
            $like->setComment($comment);
            $like->setDislike(false);


            $em->persist($like);
            $em->flush();

            $comment =$em->getRepository('TalentBundle:Comment')->findOneBy(['id' => $like->getComment()->getId()]);
            $comment->setNblike($comment->getNblike()+1);
            $em->persist($comment);
            $em->flush();

            $data = $this->get('jms_serializer')->serialize('Like !', 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }
    public function getLikeByCommentUserIDAction(Request $request, int $iduser, int $idcomment){
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('TalentBundle:User')->findOneBy(['id' => $iduser]);
        $comment = $em->getRepository('TalentBundle:Comment')->findOneBy(['id' => $idcomment]);
        $like = $em->getRepository('TalentBundle:Likes')->findOneBy(['iduser' => $user, 'comment' => $comment]);

        if ($like){
            $data = $this->get('jms_serializer')->serialize(true, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
        else {
            $data = $this->get('jms_serializer')->serialize(false, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }


    }
}
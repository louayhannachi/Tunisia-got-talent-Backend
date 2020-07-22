<?php

namespace TalentBundle\Controller;

use TalentBundle\Entity\Comment;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Comment controller.
 *
 */
class CommentController extends Controller
{
    /**
     * Creates a new comment entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = new Comment();
        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $user =$em->getRepository('TalentBundle:User')->findOneBy(['id' => $parametersAsArray['iduser']['id']]);
        $profil =$em->getRepository('TalentBundle:Profil')->findOneBy(['id' => $parametersAsArray['profil']['id']]);
        if ($profil->getIduser()->getId() != $user->getId())
        {
            $comment->setProfil($profil);
            $comment->setIduser($user);
            $comment->setText($parametersAsArray['text']);
            $comment->setNbdislike(0);
            $comment->setNblike(0);

            $em->persist($comment);
            $em->flush();

            $data = $this->get('jms_serializer')->serialize($comment, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        } else {
            $data = $this->get('jms_serializer')->serialize('You can\'t add comment to your own profil', 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $parametersAsArray = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
        }
        $comment =$em->getRepository('TalentBundle:Comment')->findOneBy(['id' => $parametersAsArray['id']]);
            $comment->setText($parametersAsArray['text']);
            $em->persist($comment);
            $em->flush();

            $data = $this->get('jms_serializer')->serialize($comment, 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
    }

    public function getCommentByProfilAction( $id){
        $em = $this->getDoctrine()->getManager();
        $comments =$em->getRepository('TalentBundle:Comment')->findBy(['profils' => $id]);
        $data = $this->get('jms_serializer')->serialize($comments, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    public function deleteAction(Request $request, $idcomment)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('TalentBundle:Comment')->findOneBy(['id' => $idcomment]);

            $em->remove($comment);
            $em->flush();
            $data = $this->get('jms_serializer')->serialize("Delete with success", 'json');
            $response = new Response($data);
            $response->headers->set('Content-Type', 'application/json');
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;

    }
}

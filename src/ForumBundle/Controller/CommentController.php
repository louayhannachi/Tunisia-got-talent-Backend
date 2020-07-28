<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class CommentController
 * @Rest\Prefix("/comment")
 * @Rest\NamePrefix("get_comments_")
 * @package ForumBundle\Controller
 */
class CommentController extends Controller
{
    use ControllerTrait;

    /**
     * Returns all comments
     *
     * @Rest\Get("/comments")
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function getAction (Request $request)
    {
        $comments = $this->getCommentRepository()->findAll();
        return new Response($this->encode($comments), Response::HTTP_OK);
    }

    /**
     * Returns comment by id
     *
     * @Rest\Get("/comment/{id}", requirements={"id"="\d+"})
     *
     * @param $id
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getIdAction ($id)
    {
        $comments = $this->getCommentRepository()->load($id);
        return new Response($this->encode($comments), Response::HTTP_OK);
    }

    /**
     * Returns comment by article id
     *
     * @Rest\Get("/commentByArticle/{article_id}", requirements={"article_id"="\d+"})
     *
     * @param $article_id
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByArticleAction ($article_id)
    {
        $comments = $this->getCommentRepository()->loadByArticleId($article_id);
        return new Response($this->encode($comments), Response::HTTP_OK);
    }

    /**
     * Add comment for specific article
     *
     * @Rest\Post("/comment/post", requirements={"article_id"="\d+"})
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function postAction (Request $request)
    {
        $content = json_decode($request->getContent());
        $article = $this->getArticleRepository()->load($content->article_id);
        $this->getCommentRepository()->create($content, $article);

        $data = $this->get('jms_serializer')->serialize("Comment added successfully", 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
        //return new Response('Comment added successfully');
    }

    /**
     * Updates comment
     *
     * @Rest\Patch("/comment/update/{id}", requirements={"id"="\d+"})
     *
     * @param Request $request
     * @param $id
     *
     * @return Response
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function patchAction (Request $request, $id)
    {
        $repository = $this->getCommentRepository();
        $comment = $repository->load($id);
        $this->getCommentRepository()->update($comment, json_decode($request->getContent()));

        return new Response('Comment edited successfully');
    }

    /**
     * Deletes article
     *
     * @Rest\Delete("/comment/delete/{id}", requirements={"id"="\d+"})
     *
     * @param $id
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction($id)
    {
        $this->getCommentRepository()->remove($id);

        return new Response('Comment deleted successfully');
    }

    /**
     * Returns comments of a given user
     *
     * @Rest\Get("/comments/{user_id}", requirements={"id"="\d+"})
     *
     * @param $user_id
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getCommentsByUserId($user_id)
    {
        $comments = $this->getCommentRepository()->loadByUserId($user_id);
        return new Response($this->encode($comments), Response::HTTP_OK);
    }
}

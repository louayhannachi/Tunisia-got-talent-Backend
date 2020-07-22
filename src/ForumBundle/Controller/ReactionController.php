<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ReactionController
 * @Rest\Prefix("/comment")
 * @Rest\NamePrefix("get_recations_")
 * @package ForumBundle\Controller
 */
class ReactionController extends Controller
{
    use ControllerTrait;

    /**
     * Returns total count of reactions
     *
     * @Rest\Get("/reactions")
     *
     * @param Request $request
     *
     * @return Response
     * @throws \Exception
     */
    public function getAction (Request $request)
    {
        $reactions = count($this->getReactionRepository()->findAll());
        return new Response($reactions, Response::HTTP_OK);
    }

    /**
     * Returns reactions for specific comment
     *
     * @Rest\Get("comment/{comment_id}/reaction", requirements={"id"="\d+"})
     *
     * @param $comment_id
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByCommentAction ($comment_id)
    {
        $reactions = $this->getReactionRepository()->loadByCommentId($comment_id);
        return new Response($this->encode($reactions), Response::HTTP_OK);
    }

    /**
     * Returns comment by article id
     *
     * @Rest\Get("article/{article_id}/reaction", requirements={"article_id"="\d+"})
     *
     * @param $article_id
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getByArticleAction ($article_id)
    {
        $reactions = $this->getReactionRepository()->loadByArticleId($article_id);

        return new Response($this->encode($reactions), Response::HTTP_OK);
    }

    /**
     * Add comment for specific article
     *
     * @Rest\Post("/reaction/post")
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
        $article = $comment = null;
        if (property_exists($content, 'article_id')) {
            $article = $this->getArticleRepository()->load($content->article_id);
        }

        if (property_exists($content, 'comment_id')) {
            $comment = $this->getCommentRepository()->load($content->comment_id);
        }
        $this->getReactionRepository()->create($content, null !== $article ? $article : $comment);

        return new Response('Reaction added successfully');
    }

    /**
     * Deletes reaction
     *
     * @Rest\Delete("/reaction/delete/{id}", requirements={"id"="\d+"})
     *
     * @param $id
     *
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function deleteAction($id)
    {
        $this->getReactionRepository()->remove($id);

        return new Response('Reaction removed successfully');
    }
}

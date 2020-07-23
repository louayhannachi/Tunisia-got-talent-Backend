<?php
namespace ForumBundle\Controller;

use ForumBundle\Entity\Comment;
use ForumBundle\Entity\Reaction;
use ForumBundle\Repository\ArticleRepository;
use ForumBundle\Repository\CommentRepository;
use ForumBundle\Repository\ReactionRepository;
use FOS\RestBundle\View\View;
use ForumBundle\ForumBundle;
use Symfony\Component\HttpFoundation\Response;

/**
 * Trait ControllerTrait
 * @package ForumBundle\Controller
 */
trait ControllerTrait
{
    /**
     *
     * @param mixed $message
     * @param int $status
     * @param array $headers
     *
     * @return View
     */
    protected function renderResponse($message, $status = Response::HTTP_BAD_REQUEST, $headers = [])
    {
        return View::create($message, $status, $headers);
    }

    /**
     * @param string $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function decode($data)
    {
        $serializer = $this->get('jms_serializer');
        return $serializer->deserialize($data);
    }

    /**
     * @param mixed $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function encode($data)
    {
        $serializer = $this->get('jms_serializer');
        return $serializer->serialize($data, 'json');
    }

    /**
     * @return ArticleRepository
     */
    protected function getArticleRepository()
    {
        return $this->get('forum.article_repository');
    }

    /**
     * @return CommentRepository
     */
    protected function getCommentRepository()
    {
        return $this->get('forum.comment_repository');
    }

    /**
     * @return ReactionRepository
     */
    protected function getReactionRepository()
    {
        return $this->get('forum.reaction_repository');
    }
}
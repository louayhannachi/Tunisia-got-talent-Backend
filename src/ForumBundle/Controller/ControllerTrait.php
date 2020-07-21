<?php
namespace ForumBundle\Controller;

use ForumBundle\Repository\ArticleRepository;
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
        /** @var \Symfony\Component\Serializer\Serializer $serializer */
        $serializer = $this->get('jms_serializer');
        return $serializer->deserialize($data);
    }

    /**
     * @param string $data
     *
     * @return mixed
     *
     * @throws \Exception
     */
    protected function encode($data)
    {
        /** @var \Symfony\Component\Serializer\Serializer $serializer */
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
}
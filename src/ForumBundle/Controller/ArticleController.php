<?php

namespace ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @Rest\Prefix("/article")
 * @Rest\NamePrefix("get_articles_")
 * @package ForumBundle\Controller
 */
class ArticleController extends Controller
{
    use ControllerTrait;

    /**
     * Returns all articles
     *
     * @Rest\Get("/articles")
     */
    public function getAction(Request $request)
    {
        $articles = $this->getArticleRepository()->findAll();
        return new Response($this->encode($articles), Response::HTTP_OK);
    }

    /**
     * Returns article by ID
     *
     * @Rest\Get("/article/{id}", requirements={"id"="\d+"})
     */
    public function getIdAction($id)
    {
        $article = $this->getArticleRepository()->load($id);
        return new Response($this->encode($article), Response::HTTP_OK);
    }

    /**
     * Add article
     *
     * @Rest\Post("/article/post")
     */
    public function postAction (Request $request)
    {
        $this->getArticleRepository()->create(json_decode($request->getContent()));
        return new Response('Article created successfully');
    }

    /**
     * Updates article
     *
     * @Rest\Patch("article/update/{id}", requirements={"id"="\d+"})
     */
    public function patchAction (Request $request, $id)
    {
        $repository = $this->getArticleRepository();
        $article = $repository->load($id);
        $this->getArticleRepository()->update($article, json_decode($request->getContent()));

        return new Response('Article updated successfully');
    }

    /**
     * Deletes articles
     *
     * @Rest\Delete("article/delete/{id}", requirements={"id"="\d+"})
     */
    public function deleteAction($id)
    {
        $this->getArticleRepository()->remove($id);

        return new Response('Article deleted successfully');
    }
}

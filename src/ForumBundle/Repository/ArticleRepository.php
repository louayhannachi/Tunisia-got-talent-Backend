<?php

namespace ForumBundle\Repository;
use ForumBundle\Entity\Article;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ArticleRepository
 * @package MorivenBundle\Repository
 */
class ArticleRepository extends Repository
{
    /**
     * @param array $content
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function create($content)
    {
        $article = new Article();
        $this->update($article, $content);
    }

    /**
     * @param Article $article
     * @param array $content
     *
     * @throws InvalidArgumentException
     */
    public function update($article, $content)
    {
        $article->setContent($content->content);
        $article->setDate($content->date);
        $this->store($article);
    }

    /**
     * @param Article $article
     * @param bool $refresh
     * @return void
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store($article, $refresh = false)
    {
        $this->_em->persist($article);
        $this->_em->flush();
        if ($refresh) {
            $this->_em->refresh($article);
        }
    }

    /**
     * @param int $id
     *
     * @return Article
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function load($id)
    {
        /** @var Article|null $article */
        if (null === ($article = $this->find($id))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        return $article;
    }
    /**
     * @param int $id
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function remove($id)
    {
        if (null === ($article = $this->load($id))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        $this->_em->remove($article);
        $this->_em->flush($article);
    }
}
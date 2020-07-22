<?php

namespace ForumBundle\Repository;

use ForumBundle\Entity\Article;
use ForumBundle\Entity\Comment;
use ForumBundle\Entity\Reaction;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class ReactionRepository
 * @package ForumBundle\Repository
 */
class ReactionRepository extends Repository
{
    /**
     * @param array $content
     * @param Comment|Article $context
     *
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function create($content, $context)
    {
        $reaction = new Reaction();
        $this->update($reaction, $content, $context);
    }

    /**
     * @param Reaction $reaction
     *
     * @param array $content
     * @param Comment|Article $context
     *
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function update($reaction, $content, $context)
    {
        if (null === $context) {
            throw new InvalidArgumentException('Reaction should be associated to an article or comment');
        }

        foreach ($content as $property => $value) {
            $reaction->{$property} = $value;
        }

        $context instanceof Article ? $reaction->setArticle($context) : $reaction->setComment($context);

        $this->store($reaction);
    }

    /**
     * @param Reaction $reaction
     * @param bool $refresh
     *
     * @return void
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store($reaction, $refresh = false)
    {
        $this->_em->persist($reaction);
        $this->_em->flush();
        if ($refresh) {
            $this->_em->refresh($reaction);
        }
    }

    /**
     * @param int $id
     *
     * @return Reaction
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function load($id)
    {
        /** @var Reaction|null $reaction */
        if (null === ($reaction = $this->find($id))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        return $reaction;
    }

    /**
     * @param int $id
     *
     * @return Reaction
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function loadByArticleId($id)
    {
        /** @var Reaction|null $reaction */
        if (null === ($reaction = $this->findBy(['article' => $id]))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        return $reaction;
    }

    /**
     * @param int $id
     *
     * @return Reaction
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function loadByCommentId($id)
    {
        /** @var Reaction|null $reaction */
        if (null === ($reaction = $this->findBy(['comment' => $id]))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        return $reaction;
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
        if (null === ($reaction = $this->load($id))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        $this->_em->remove($reaction);
        $this->_em->flush($reaction);
    }
}
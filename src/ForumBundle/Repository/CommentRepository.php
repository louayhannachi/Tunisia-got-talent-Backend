<?php

namespace ForumBundle\Repository;
use ForumBundle\Entity\Article;
use ForumBundle\Entity\Comment;
use Doctrine\DBAL\Exception\InvalidArgumentException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class CommentRepository
 * @package ForumBundle\Repository
 */
class CommentRepository extends Repository
{
    /**
     * @param array $content
     * @param Article $article
     * @throws \Doctrine\DBAL\Exception\InvalidArgumentException
     */
    public function create($content, $article)
    {
        $comment = new Comment();
        $this->update($comment, $content, $article);
    }

    /**
     * @param Comment $comment
     * @param array $content
     * @param Article $article
     *
     * @throws InvalidArgumentException
     */
    public function update($comment, $content, $article = null)
    {
        foreach ($content as $property => $value) {
            if ($property === "user_id"){
                if (null !== ($user = $this->_em->getRepository('TalentBundle:User')->find($article->user))){
                    $comment->setUser($user);
                }
            }else{
                $comment->{$property} = $value;
            }
        }

        if (null !== $article) {
            $comment->setArticle($article);
        }
        $this->store($comment);
    }

    /**
     * @param Comment $comment
     * @param bool $refresh
     * @return void
     *
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function store($comment, $refresh = false)
    {
        $this->_em->persist($comment);
        $this->_em->flush();
        if ($refresh) {
            $this->_em->refresh($comment);
        }
    }

    /**
     * @param int $id
     *
     * @return Comment
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function load($id)
    {
        /** @var Comment|null $comment */
        if (null === ($comment = $this->find($id))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        return $comment;
    }

    /**
     * @param int $id
     *
     * @return Comment
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function loadByArticleId($id)
    {
        /** @var Comment|null $comment */
        if (null === ($comment = $this->findBy(['article' => $id]))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        return $comment;
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
        if (null === ($comment = $this->load($id))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        $this->_em->remove($comment);
        $this->_em->flush($comment);
    }

    /**
     * @param int $id
     *
     * @return array
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function loadByUserId($id)
    {
        if (null === ($comments = $this->findBy(['user' => $id]))) {
            throw new NotFoundHttpException(
                (new \ReflectionClass($this->getClassName()))->getShortName() . ' not found with given Id.'
            );
        }
        return $comments;
    }
}
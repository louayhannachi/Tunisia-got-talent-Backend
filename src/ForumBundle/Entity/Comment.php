<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TalentBundle\Entity\User;

/**
 * Article
 *
 * @ORM\Table(name="forum_comment")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\CommentRepository")
 */
class Comment
{

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    public $id;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="string")
     */
    public $value;

    /**
     * @var Article
     *
     * @ORM\ManyToOne(targetEntity="Article")
     * @ORM\JoinColumn(name="article_id", nullable=false, referencedColumnName="id")
     */
    protected $article;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="TalentBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", nullable=false, referencedColumnName="id")
     */
    protected $user;


    /**
     * @var string
     *
     * @ORM\Column(name="publication_date", type="string", length=255)
     */
    public $publication_date;

    /**
     * @var string
     *
     * @ORM\Column(name="modification_date", type="string", length=255, nullable=true)
     */
    public $modification_date;

    /**
     * @return Article
     */
    public function getArticle()
    {
        return $this->article;
    }

    /**
     * @param Article $article
     */
    public function setArticle($article)
    {
        $this->article = $article;
    }
    /**
     * @return \TalentBundle\Entity\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

}


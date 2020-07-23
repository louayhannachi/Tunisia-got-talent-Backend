<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use TalentBundle\Entity\User;

/**
 * Article
 *
 * @ORM\Table(name="forum_article")
 * @ORM\Entity(repositoryClass="ForumBundle\Repository\ArticleRepository")
 */
class Article
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
     * @ORM\Column(name="content", type="string", length=255)
     */
    public $content;

    /**
     * @var string
     *
     * @ORM\Column(name="category", type="string", length=255)
     */
    public $category;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="publication_date", type="string")
     */
    public $publication_date;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="TalentBundle\Entity\User")
     * @ORM\JoinColumn(name="user_id", nullable=false, referencedColumnName="id")
     */
    public $user;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modification_date", type="string", nullable=true)
     */
    public $modification_date;

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
        return $this;
    }
}


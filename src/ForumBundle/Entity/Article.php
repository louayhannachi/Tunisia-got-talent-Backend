<?php

namespace ForumBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

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
     * @var \DateTime
     *
     * @ORM\Column(name="modification_date", type="string", nullable=true)
     */
    public $modification_date;
}


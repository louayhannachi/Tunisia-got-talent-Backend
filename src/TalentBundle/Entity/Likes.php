<?php

namespace TalentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Likes
 *
 * @ORM\Table(name="likes", indexes={@ORM\Index(name="idUser", columns={"idUser"}), @ORM\Index(name="comment", columns={"comment"})})
 * @ORM\Entity(repositoryClass="TalentBundle\Repository\LikesRepository")
 */
class Likes
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var boolean
     *
     * @ORM\Column(name="dislike", type="boolean", nullable=false)
     */
    private $dislike;

    /**
     * @var \TalentBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="TalentBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idUser", referencedColumnName="id")
     * })
     */
    private $iduser;

    /**
     * @var \TalentBundle\Entity\Comment
     *
     * @ORM\ManyToOne(targetEntity="TalentBundle\Entity\Comment")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="comment", referencedColumnName="id")
     * })
     */
    private $comment;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Likes
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return bool
     */
    public function isDislike()
    {
        return $this->dislike;
    }

    /**
     * @param bool $dislike
     * @return Likes
     */
    public function setDislike($dislike)
    {
        $this->dislike = $dislike;
        return $this;
    }

    /**
     * @return User
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param User $iduser
     * @return Likes
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
        return $this;
    }

    /**
     * @return Comment
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @param Comment $comment
     * @return Likes
     */
    public function setComment($comment)
    {
        $this->comment = $comment;
        return $this;
    }



}


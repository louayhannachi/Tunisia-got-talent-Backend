<?php

namespace TalentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comment
 *
 * @ORM\Table(name="comment", indexes={@ORM\Index(name="profil", columns={"profil"}), @ORM\Index(name="idUser", columns={"idUser"})})
 * @ORM\Entity(repositoryClass="TalentBundle\Repository\CommentRepository")
 */
class Comment
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
     * @var string
     *
     * @ORM\Column(name="text", type="string", length=255, nullable=false)
     */
    private $text;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbLike", type="integer", nullable=false)
     */
    private $nblike;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbDislike", type="integer", nullable=false)
     */
    private $nbdislike;

    /**
     * @var \TalentBundle\Entity\Profil
     *
     * @ORM\ManyToOne(targetEntity="TalentBundle\Entity\Profil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profil", referencedColumnName="id", onDelete="CASCADE")
     * })
     */
    private $profils;

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
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Comment
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param string $text
     * @return Comment
     */
    public function setText($text)
    {
        $this->text = $text;
        return $this;
    }

    /**
     * @return int
     */
    public function getNblike()
    {
        return $this->nblike;
    }

    /**
     * @param int $nblike
     * @return Comment
     */
    public function setNblike($nblike)
    {
        $this->nblike = $nblike;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbdislike()
    {
        return $this->nbdislike;
    }

    /**
     * @param int $nbdislike
     * @return Comment
     */
    public function setNbdislike($nbdislike)
    {
        $this->nbdislike = $nbdislike;
        return $this;
    }

    /**
     * @return Profil
     */
    public function getProfil()
    {
        return $this->profils;
    }

    /**
     * @param Profil $profil
     * @return Comment
     */
    public function setProfil($profils)
    {
        $this->profils = $profils;
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
     * @return Comment
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
        return $this;
    }


}


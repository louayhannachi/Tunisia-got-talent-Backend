<?php

namespace TalentBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rating
 *
 * @ORM\Table(name="rating", indexes={@ORM\Index(name="profil", columns={"profil"}), @ORM\Index(name="idUser", columns={"idUser"})})
 * @ORM\Entity(repositoryClass="TalentBundle\Repository\RatingRepository")
 */
class Rating
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
     * @ORM\Column(name="rate", type="string", length=255, nullable=false)
     */
    private $rate;

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
     * @var \TalentBundle\Entity\Profil
     *
     * @ORM\ManyToOne(targetEntity="TalentBundle\Entity\Profil")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="profil", referencedColumnName="id")
     * })
     */
    private $profil;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Rating
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getRate()
    {
        return $this->rate;
    }

    /**
     * @param string $rate
     * @return Rating
     */
    public function setRate($rate)
    {
        $this->rate = $rate;
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
     * @return Rating
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
        return $this;
    }

    /**
     * @return Profil
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * @param Profil $profil
     * @return Rating
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;
        return $this;
    }


}


<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Evenement
 *
 * @ORM\Table(name="evenement", indexes={@ORM\Index(name="idCat", columns={"idCat"})})
 * @ORM\Entity
 */
class Evenement
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
     * @ORM\Column(name="titre", type="string", length=255, nullable=false)
     */
    private $titre;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime", nullable=false)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=false)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="nbparticipant", type="integer", nullable=false)
     */
    private $nbparticipant;

    /**
     * @var \EventBundle\Entity\CategoryEvent
     *
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\CategoryEvent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idcat", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $idcat;

    /**
     * @var \TalentBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="TalentBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $iduser;

    /**
     * @var \EventBundle\Entity\CategoryEvent
     *
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\CategoryEvent")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idCat", referencedColumnName="id")
     * })
     */
    private $idCat;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     * @return Evenement
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return Evenement
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param \DateTime $date
     * @return Evenement
     */
    public function setDate($date)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Evenement
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return int
     */
    public function getNbparticipant()
    {
        return $this->nbparticipant;
    }

    /**
     * @param int $nbparticipant
     * @return Evenement
     */
    public function setNbparticipant($nbparticipant)
    {
        $this->nbparticipant = $nbparticipant;
        return $this;
    }

    /**
     * @return CategoryEvent
     */
    public function getIdcat()
    {
        return $this->idcat;
    }

    /**
     * @param CategoryEvent $idcat
     * @return Evenement
     */
    public function setIdcat($idcat)
    {
        $this->idcat = $idcat;
        return $this;
    }

    /**
     * @return \TalentBundle\Entity\User
     */
    public function getIduser()
    {
        return $this->iduser;
    }

    /**
     * @param \TalentBundle\Entity\User $iduser
     * @return Evenement
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
        return $this;
    }

}


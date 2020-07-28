<?php

namespace CompetitionBundle\Entity;

/**
 * Competition
 */
class Competition
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $nom;

    /**
     * @var string
     */
    private $description;

    /**
     * @var string
     */
    private $dateDebut;

    /**
     * @var string
     */
    private $dateFin;

    /**
     * @var string
     */
    private $nbParticipant;

    /**
     * @var string
     */
    private $nbMaxParticipant;

    /**
     * @var string
     */
    private $compType;

    /**
     * @var string
     */
    private $userId;


    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Competition
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
    
        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Competition
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set dateDebut
     *
     * @param string $dateDebut
     *
     * @return Competition
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;
    
        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return string
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param string $dateFin
     *
     * @return Competition
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;
    
        return $this;
    }

    /**
     * Get dateFin
     *
     * @return string
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }

    /**
     * Set nbParticipant
     *
     * @param string $nbParticipant
     *
     * @return Competition
     */
    public function setNbParticipant($nbParticipant)
    {
        $this->nbParticipant = $nbParticipant;
    
        return $this;
    }

    /**
     * Get nbParticipant
     *
     * @return string
     */
    public function getNbParticipant()
    {
        return $this->nbParticipant;
    }

  /**
     * Set nbMaxParticipant
     *
     * @param string $nbMaxParticipant
     *
     * @return Competition
     */
    public function setNbMaxParticipant($nbMaxParticipant)
    {
        $this->nbMaxParticipant = $nbMaxParticipant;
    
        return $this;
    }

    /**
     * Get nbMaxParticipant
     *
     * @return string
     */
    public function getNbMaxParticipant()
    {
        return $this->nbMaxParticipant;
    }

    
  /**
     * Set compType
     *
     * @param string $compType
     *
     * @return Competition
     */
    public function setCompType($compType)
    {
        $this->compType = $compType;
    
        return $this;
    }

    /**
     * Get compType
     *
     * @return string
     */
    public function getCompType()
    {
        return $this->compType;
    }


        /**
     * Get UserId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set userId
     *
     * @param string $userId
     *
     * @return Competition
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;
    
        return $this;
    }



}


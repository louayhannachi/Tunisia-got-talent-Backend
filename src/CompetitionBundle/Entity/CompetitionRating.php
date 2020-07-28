<?php

namespace CompetitionBundle\Entity;

/**
 * CompetitionRating
 */
class CompetitionRating
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $idComp;

    /**
     * @var string
     */
    private $idUser;

    /**
     * @var string
     */
    private $rateValue;


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
     * Set idComp
     *
     * @param string $idComp
     *
     * @return CompetitionRating
     */
    public function setIdComp($idComp)
    {
        $this->idComp = $idComp;
    
        return $this;
    }

    /**
     * Get idComp
     *
     * @return string
     */
    public function getIdComp()
    {
        return $this->idComp;
    }

    /**
     * Set idUser
     *
     * @param string $idUser
     *
     * @return CompetitionRating
     */
    public function setIdUser($idUser)
    {
        $this->idUser = $idUser;
    
        return $this;
    }

    /**
     * Get idUser
     *
     * @return string
     */
    public function getIdUser()
    {
        return $this->idUser;
    }

    /**
     * Set rateValue
     *
     * @param string $rateValue
     *
     * @return CompetitionRating
     */
    public function setRateValue($rateValue)
    {
        $this->rateValue = $rateValue;
    
        return $this;
    }

    /**
     * Get rateValue
     *
     * @return string
     */
    public function getRateValue()
    {
        return $this->rateValue;
    }
}


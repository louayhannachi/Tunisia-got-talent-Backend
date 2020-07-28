<?php

namespace CompetitionBundle\Entity;

/**
 * CompetitionParticipation
 */
class CompetitionParticipation
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
     * @return CompetitionParticipation
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
     * @return CompetitionParticipation
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
}


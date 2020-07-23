<?php


namespace TalentBundle\Entity;



class count
{
    /**
     * @var String
     *
     */
    private $username;

    /**
     * @var number
     *
     */
    private $nbslike;

    /**
     * @return String
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @param String $username
     * @return count
     */
    public function setUsername($username)
    {
        $this->username = $username;
        return $this;
    }

    /**
     * @return number
     */
    public function getNbslike()
    {
        return $this->nbslike;
    }

    /**
     * @param number $nbslike
     * @return count
     */
    public function setNbslike($nbslike)
    {
        $this->nbslike = $nbslike;
        return $this;
    }

}
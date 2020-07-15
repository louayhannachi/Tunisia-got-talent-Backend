<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * RatingEvent
 *
 * @ORM\Table(name="rating_event", indexes={@ORM\Index(name="iduser", columns={"iduser"}), @ORM\Index(name="idevent", columns={"idevent"})})
 * @ORM\Entity
 */
class RatingEvent
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
     * @var \TalentBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="TalentBundle\Entity\User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="iduser", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $iduser;

    /**
     * @var \EventBundle\Entity\Evenement
     *
     * @ORM\ManyToOne(targetEntity="EventBundle\Entity\Evenement")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="idevent", referencedColumnName="id",onDelete="CASCADE")
     * })
     */
    private $idevent;
    /**
     * @var integer
     *
     * @ORM\Column(name="valueEvent", type="integer")
     */
    private $valueEvent;
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
     */
    public function setIduser($iduser)
    {
        $this->iduser = $iduser;
    }

    /**
     * @return Evenement
     */
    public function getIdevent()
    {
        return $this->idevent;
    }

    /**
     * @param Evenement $idevent
     */
    public function setIdevent($idevent)
    {
        $this->idevent = $idevent;
    }

    /**
     * @return int
     */
    public function getValueEvent()
    {
        return $this->valueEvent;
    }

    /**
     * @param int $valueEvent
     */
    public function setValueEvent($valueEvent)
    {
        $this->valueEvent = $valueEvent;
    }


}


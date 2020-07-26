<?php

namespace SponsoringBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sponsorise
 *
 * @ORM\Table(name="sponsorise")
 * @ORM\Entity(repositoryClass="SponsoringBundle\Repository\SponsoriseRepository")
 */
class Sponsorise
{
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
     * @ORM\ManyToOne(targetEntity="Entreprise")
     * @ORM\JoinColumn(name="Entreprise_id", referencedColumnName="id")
     */
    private $entreprise;

    /**
     * @return mixed
     */
    public function getEntreprise()
    {
        return $this->entreprise;
    }

    /**
     * @param mixed $entreprise
     */
    public function setEntreprise($entreprise)
    {
        $this->entreprise = $entreprise;
    }


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     */
    private $type;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_sp", type="date")
     */
    private $dateSp;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Sponsorise
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateSp
     *
     * @param \DateTime $dateSp
     *
     * @return Sponsorise
     */
    public function setDateSp($dateSp)
    {
        $this->dateSp = $dateSp;

        return $this;
    }

    /**
     * Get dateSp
     *
     * @return \DateTime
     */
    public function getDateSp()
    {
        return $this->dateSp;
    }
}


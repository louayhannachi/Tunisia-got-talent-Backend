<?php

namespace SponsoringBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entreprise
 *
 * @ORM\Table(name="entreprise")
 * @ORM\Entity(repositoryClass="SponsoringBundle\Repository\EntrepriseRepository")
 */
class Entreprise
{
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
     * @ORM\Column(name="nom", type="string", length=255)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="lieux", type="string", length=255)
     */
    private $lieux;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=255)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="site_officiel", type="string", length=255)
     */
    private $siteOfficiel;

    /**
     * @var int
     *
     * @ORM\Column(name="nbr_employe", type="integer")
     */
    private $nbrEmploye;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_creation", type="date")
     */
    private $dateCreation;


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
     * Set nom
     *
     * @param string $nom
     *
     * @return Entreprise
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
     * Set lieux
     *
     * @param string $lieux
     *
     * @return Entreprise
     */
    public function setLieux($lieux)
    {
        $this->lieux = $lieux;

        return $this;
    }

    /**
     * Get lieux
     *
     * @return string
     */
    public function getLieux()
    {
        return $this->lieux;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Entreprise
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set siteOfficiel
     *
     * @param string $siteOfficiel
     *
     * @return Entreprise
     */
    public function setSiteOfficiel($siteOfficiel)
    {
        $this->siteOfficiel = $siteOfficiel;

        return $this;
    }

    /**
     * Get siteOfficiel
     *
     * @return string
     */
    public function getSiteOfficiel()
    {
        return $this->siteOfficiel;
    }

    /**
     * Set nbrEmploye
     *
     * @param integer $nbrEmploye
     *
     * @return Entreprise
     */
    public function setNbrEmploye($nbrEmploye)
    {
        $this->nbrEmploye = $nbrEmploye;

        return $this;
    }

    /**
     * Get nbrEmploye
     *
     * @return int
     */
    public function getNbrEmploye()
    {
        return $this->nbrEmploye;
    }

    /**
     * Set dateCreation
     *
     * @param \DateTime $dateCreation
     *
     * @return Entreprise
     */
    public function setDateCreation($dateCreation)
    {
        $this->dateCreation = $dateCreation;

        return $this;
    }

    /**
     * Get dateCreation
     *
     * @return \DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }
}


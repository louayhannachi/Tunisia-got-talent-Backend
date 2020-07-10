<?php

namespace EventBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CategoryEvent
 *
 * @ORM\Table(name="category_event")
 * @ORM\Entity
 */
class CategoryEvent
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
     * @ORM\Column(name="titreCat", type="string", length=255, nullable=false)
     */
    private $titrecat;

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
     * @return string
     */
    public function getTitrecat()
    {
        return $this->titrecat;
    }

    /**
     * @param string $titrecat
     */
    public function setTitrecat($titrecat)
    {
        $this->titrecat = $titrecat;
    }


}


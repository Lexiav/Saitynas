<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */

class Animal
{


    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string",length=255,  nullable=true)
     *
     */
    private $species;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $name;
    /**
     * @ORM\Column(type="integer", nullable=true)
     *
     */
    private $age;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Cage", inversedBy="Cage")
     */
    private $cage;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * @param mixed $species
     */
    public function setSpecies($species): void
    {
        $this->species = $species;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * @param mixed $age
     */
    public function setAge($age): void
    {
        $this->age = $age;
    }

    /**
     * @return Cage
     */
    public function getCage()
    {
        return $this->cage;
    }

    /**
     * @param mixed $cage
     */
    public function setCage($cage): void
    {
        $this->cage = $cage;
    }

}
<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity
 */

class Tests
{


    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     *
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Users", inversedBy="Users")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Groups", inversedBy="Groups")
     */
    private $group;

    /**
     * @ORM\Column(type="integer")
     */
    private $questionsCount;

    /**
     * @ORM\Column(type="datetime" , nullable=true)
     */
    private $startTime;

    /**
     * @ORM\Column(type="datetime", nullable=true)

     */
    private $endTime;
    /**
     * @ORM\Column(type="integer",  nullable=true)
     */
    private $duration;

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
     * @return Users
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }

    /**
     * @return Groups
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * @param mixed $group
     */
    public function setGroup($group): void
    {
        $this->group = $group;
    }

    /**
     * @return int
     */
    public function getQuestionsCount(): int
    {
        return $this->questionsCount;
    }

    /**
     * @param int $questionsCount
     */
    public function setQuestionsCount(int $questionsCount): void
    {
        $this->questionsCount = $questionsCount;
    }

    /**
     * @return \DateTime
     */
    public function getStartTime(): \DateTime
    {
        return $this->startTime;
    }

    /**
     * @param \DateTime $startTime
     */
    public function setStartTime(\DateTime $startTime): void
    {
        $this->startTime = $startTime;
    }

    /**
     * @return \DateTime
     */
    public function getEndTime(): \DateTime
    {
        return $this->endTime;
    }

    /**
     * @param \DateTime $endTime
     */
    public function setEndTime(\DateTime $endTime): void
    {
        $this->endTime = $endTime;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }


}
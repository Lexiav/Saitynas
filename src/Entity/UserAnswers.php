<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */

class UserAnswers
{


    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\UserTests", inversedBy="UserTests")
     */
    private $userTest;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Questions", inversedBy="Questions")
     */
    private $question;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $answer;
    /**
     * @ORM\Column (type="float")
     */
    private $points;

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
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param mixed $answer
     */
    public function setAnswer($answer): void
    {
        $this->answer = $answer;
    }

    /**
     * @return mixed
     */
    public function getPoints()
    {
        return $this->points;
    }

    /**
     * @param mixed $points
     */
    public function setPoints($points): void
    {
        $this->points = $points;
    }

    /**
     * @return Tests
     */
    public function getUserTest()
    {
        return $this->userTest;
    }

    /**
     * @param mixed $userTest
     */
    public function setUserTest($userTest): void
    {
        $this->userTest = $userTest;
    }

    /**
     * @return Questions
     */
    public function getQuestion()
    {
        return $this->question;
    }

    /**
     * @param mixed $question
     */
    public function setQuestion($question): void
    {
        $this->question = $question;
    }


}
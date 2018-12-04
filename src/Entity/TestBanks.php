<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */

class TestBanks
{


    /**
     * @ORM\Id()
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Tests", inversedBy="Tests")
     */
    private $test;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionBank", inversedBy="QuestionBank")
     */
    private $questionBank;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Tests
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * @param mixed $test
     */
    public function setTest($test): void
    {
        $this->test = $test;
    }

    /**
     * @return QuestionBank
     */
    public function getQuestionBank()
    {
        return $this->questionBank;
    }

    /**
     * @param mixed $questionBank
     */
    public function setQuestionBank($questionBank): void
    {
        $this->questionBank = $questionBank;
    }


}
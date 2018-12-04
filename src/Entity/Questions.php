<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 */

class Questions
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
    private $question;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionBank", inversedBy="QuestionBank")
     */
    private $questionBank;

    /**
     * @ORM\Column(type="integer")
     *
     * Types:
     * 1 - Single Answer
     * 2 - Multi Answers
     */
    private $type;

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

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type): void
    {
        $this->type = $type;
    }


}
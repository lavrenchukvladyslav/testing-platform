<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ResultsRepository")
 */
class Results
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Question", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $question;

//    /**
//     * @ORM\OneToOne(targetEntity="App\Entity\Answer", cascade={"persist", "remove"})
//     * @ORM\JoinColumn(nullable=false)
//     */
//    private $resultAnswer;

    /**
     * @ORM\Column(type="boolean")
     */
    private $takenAnswer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?Question
    {
        return $this->question;
    }

    public function setQuestion(Question $question): self
    {
        $this->question = $question;

        return $this;
    }

//    public function getResultAnswer(): ?Answer
//    {
//        return $this->resultAnswer;
//    }
//
//    public function setResultAnswer(Answer $resultAnswer): self
//    {
//        $this->resultAnswer = $resultAnswer;
//
//        return $this;
//    }

    public function getTakenAnswer(): ?bool
    {
        return $this->takenAnswer;
    }

    public function setTakenAnswer(bool $takenAnswer): self
    {
        $this->takenAnswer = $takenAnswer;

        return $this;
    }
}

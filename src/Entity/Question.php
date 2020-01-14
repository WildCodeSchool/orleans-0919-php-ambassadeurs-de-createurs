<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre question doit être au plus {{ limit }} caractères de long")
     */
    private $question;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $answer;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\QuestionCategory", inversedBy="questions")
     * @ORM\JoinColumn(nullable=false)
     */
    private $category;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): self
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswer(): ?string
    {
        return $this->answer;
    }

    public function setAnswer(string $answer): self
    {
        $this->answer = $answer;

        return $this;
    }

    public function getCategory(): ?QuestionCategory
    {
        return $this->category;
    }

    public function setCategory(?QuestionCategory $category): self
    {
        $this->category = $category;

        return $this;
    }
}

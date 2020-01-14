<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\SubscriptionRepository")
 */
class Subscription
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $oneMonth;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $sixMonth;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $oneYear;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOneMonth(): ?int
    {
        return $this->oneMonth;
    }

    public function setOneMonth(?int $oneMonth): self
    {
        $this->oneMonth = $oneMonth;

        return $this;
    }

    public function getSixMonth(): ?int
    {
        return $this->sixMonth;
    }

    public function setSixMonth(?int $sixMonth): self
    {
        $this->sixMonth = $sixMonth;

        return $this;
    }

    public function getOneYear(): ?int
    {
        return $this->oneYear;
    }

    public function setOneYear(?int $oneYear): self
    {
        $this->oneYear = $oneYear;

        return $this;
    }
}

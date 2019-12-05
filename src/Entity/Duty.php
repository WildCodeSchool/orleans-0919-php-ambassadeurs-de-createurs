<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DutyRepository")
 */
class Duty
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $seller;

    /**
     * @ORM\Column(type="boolean")
     */
    private $host;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", mappedBy="duty", cascade={"persist", "remove"})
     */
    private $user;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeller(): ?bool
    {
        return $this->seller;
    }

    public function setSeller(bool $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function getHost(): ?bool
    {
        return $this->host;
    }

    public function setHost(bool $host): self
    {
        $this->host = $host;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        // set the owning side of the relation if necessary
        if ($user->getDuty() !== $this) {
            $user->setDuty($this);
        }

        return $this;
    }

    public function getDuties(): ?string
    {
        $duties ='';
        switch (true) {
            case ($this->host && $this->seller):
                $duties = 'Hôte et vendeur';
                break;
            case ($this->host):
                $duties = 'Hôte';
                break;
            case ($this->seller):
                $duties = 'Vendeur';
                break;
        }
        return $duties;
    }
}

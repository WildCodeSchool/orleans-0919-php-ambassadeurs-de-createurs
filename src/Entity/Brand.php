<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\BrandRepository")
 */
class Brand
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank(message="Le nom de la marque est obligatoire")
     * @Assert\Length(
     *      max = 150,
     *      maxMessage = "Votre nom de marque ne doit pas depasser {{limit}} caractères de long")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre lien ne doit pas depasser {{limit}} caractères de long")
     */
    private $site;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre lien ne doit pas depasser {{limit}} caractères de long")
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La récompense pour les hôtes est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre recompense ne doit pas depasser {{limit}} caractères de long")
     */
    private $hostAdvantage;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La récompense pour les vendeurs est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre recompense ne doit pas depasser {{limit}} caractères de long")
     */
    private $sellerAdvantage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="brand", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $sellDescription;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSite(): ?string
    {
        return $this->site;
    }

    public function setSite(?string $site): self
    {
        $this->site = $site;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getHostAdvantage(): ?string
    {
        return $this->hostAdvantage;
    }

    public function setHostAdvantage(string $hostAdvantage): self
    {
        $this->hostAdvantage = $hostAdvantage;

        return $this;
    }

    public function getSellerAdvantage(): ?string
    {
        return $this->sellerAdvantage;
    }

    public function setSellerAdvantage(string $sellerAdvantage): self
    {
        $this->sellerAdvantage = $sellerAdvantage;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSellDescription(): ?string
    {
        return $this->sellDescription;
    }

    public function setSellDescription(?string $sellDescription): self
    {
        $this->sellDescription = $sellDescription;

        return $this;
    }
}

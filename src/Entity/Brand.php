<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre recompense ne doit pas depasser {{limit}} caractères de long")
     */
    private $hostAdvantage;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre recompense ne doit pas depasser {{limit}} caractères de long")
     */
    private $sellerAdvantage;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="brand")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Event", mappedBy="brand")
     */

    private $sponsoredEvents;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $sellDescription;


    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="boolean")
     */
    private $chosenCreator = false;

    /**
     * @ORM\Column(type="boolean")
     * @Assert\Type(type="boolean")
     */
    private $hasSubscribe = false;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Gallery", mappedBy="galleryOwner", orphanRemoval=true)
     */
    private $galleries;

    public function __construct()
    {
        $this->sponsoredEvents = new ArrayCollection();
        $this->galleries = new ArrayCollection();
    }

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

    /**
     * @return Collection|Event[]
     */
    public function getsponsoredEvents(): Collection
    {
        return $this->sponsoredEvents;
    }
    public function addEventSponsored(Event $event): self
    {
        if (!$this->sponsoredEvents->contains($event)) {
            $this->sponsoredEvents[] = $event;
            $event->setBrand($this);
        }
        return $this;
    }
    public function removeEventSponsored(Event $event): self
    {
        if ($this->sponsoredEvents->contains($event)) {
            $this->sponsoredEvents->removeElement($event);
            // set the owning side to null (unless already changed)
            if ($event->getBrand() === $this) {
                $event->setBrand(null);
            }
        }
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

    public function getChosenCreator(): ?bool
    {
        return $this->chosenCreator;
    }

    public function setChosenCreator(bool $chosenCreator): self
    {
        $this->chosenCreator = $chosenCreator;

        return $this;
    }

    public function getHasSubscribe(): ?bool
    {
        return $this->hasSubscribe;
    }

    public function setHasSubscribe(bool $hasSubscribe): self
    {
        $this->hasSubscribe = $hasSubscribe;

        return $this;
    }

    /**
     * @return Collection|Gallery[]
     */
    public function getGalleries(): Collection
    {
        return $this->galleries;
    }

    public function addGallery(Gallery $gallery): self
    {
        if (!$this->galleries->contains($gallery)) {
            $this->galleries[] = $gallery;
            $gallery->setGalleryOWner($this);
        }

        return $this;
    }

    public function removeGallery(Gallery $gallery): self
    {
        if ($this->galleries->contains($gallery)) {
            $this->galleries->removeElement($gallery);
            // set the owning side to null (unless already changed)
            if ($gallery->getGalleryOWner() === $this) {
                $gallery->setGalleryOWner(null);
            }
        }

        return $this;
    }
}

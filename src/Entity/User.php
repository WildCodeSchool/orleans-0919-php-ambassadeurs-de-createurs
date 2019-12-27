<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User
{

    const ROLES = ['Ambassadeur' => 'Ambassadeur', 'Créateur' => 'Créateur'];

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ prénom est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre prénom doit être au plus {{ limit }} caractères de long")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ nom est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre nom doit être au plus {{ limit }} caractères de long")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=255)
     * )
     */
    private $picture;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="La ville de résidence est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "le nom de la ville ne doit pas dépasser {{ limit }} caractères")
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse mail est obligatoire")
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Votre adresse mail doit être au plus {{ limit }} caractères de long")
     * @Assert\Email(message="Format d'adresse invalinde")
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "Le rôle doit être au plus {{ limit }} caractères de long")
     * @Assert\Choice(choices=User::ROLES, message="Rôle invalide")
     */
    private $roles;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Department", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $department;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Duty", inversedBy="users")
     * @ORM\Column(type="string")
     */
    private $duties;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Category", inversedBy="users")
     * @ORM\Column(type="string")
     */
    private $categories;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "URL trop longue, elle doit être au plus {{ limit }} caractères")
     * @Assert\Url(
     *     message="Format d'URL non valide")
     */
    private $urlFacebook;

    public function __construct()
    {
        $this->duties = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return $this
     */
    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return $this
     */
    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * @param string $picture
     * @return $this
     */
    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * @param string|null $city
     * @return $this
     */
    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getMail(): ?string
    {
        return $this->mail;
    }

    /**
     * @param string $mail
     * @return $this
     */
    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getRoles(): ?string
    {
        return $this->roles;
    }

    /**
     * @param string $role
     * @return $this
     */
    public function setRoles(string $role): self
    {
        $this->roles = $role;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Department|null
     */
    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    /**
     * @param Department|null $department
     * @return $this
     */
    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    /**
     * @return Collection|Duty[]
     */
    public function getDuties(): Collection
    {
        return $this->duties;
    }

    /**
     * @param Duty $duty
     * @return $this
     */
    public function addDuty(Duty $duty): self
    {
        if (!$this->duties->contains($duty)) {
            $this->duties[] = $duty;
            $duty->addUser($this);
        }
        return $this;
    }

    /**
     * @return Collection|Category[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function addCategory(Category $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->addUser($this);
        }
        return $this;
    }

    /**
     * @param Duty $duty
     * @return $this
     */
    public function removeDuty(Duty $duty): self
    {
        if ($this->duties->contains($duty)) {
            $this->duties->removeElement($duty);
        }
    }

    /**
     * @param Category $category
     * @return $this
     */
    public function removeCategory(Category $category): self
    {
        if ($this->categories->contains($category)) {
            $this->categories->removeElement($category);
            $category->removeUser($this);
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUrlFacebook(): ?string
    {
        return $this->urlFacebook;
    }

    /**
     * @param string|null $urlFacebook
     * @return $this
     */
    public function setUrlFacebook(?string $urlFacebook): self
    {
        $this->urlFacebook = $urlFacebook;

        return $this;
    }
}

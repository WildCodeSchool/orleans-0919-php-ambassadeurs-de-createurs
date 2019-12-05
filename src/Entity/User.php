<?php

namespace App\Entity;

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
     * @ORM\Column(type="string", length=255, nullable=true)
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
     *@Assert\Length(
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
     * @ORM\ManyToOne(targetEntity="App\Entity\Duty", inversedBy="users")
     * @ORM\JoinColumn(nullable=false)
     */
    private $duty;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getRoles(): ?string
    {
        return $this->roles;
    }

    public function setRoles(string $role): self
    {
        $this->roles = $role;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getDepartment(): ?Department
    {
        return $this->department;
    }

    public function setDepartment(?Department $department): self
    {
        $this->department = $department;

        return $this;
    }

    public function getDuty(): ?Duty
    {
        return $this->duty;
    }

    public function setDuty(Duty $duty): self
    {
        $this->duty = $duty;

        return $this;
    }
}

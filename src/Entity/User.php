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
     *      min = 2,
     *      max = 255,
     *      minMessage = "Votre prénom doit être au moins {{ limit }} caractères de long",
     *      maxMessage = "Votre prénom doit être au plus {{ limit }} caractères de long")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Le champ nom est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Votre nom doit être au moins {{ limit }} caractères de long",
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
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length(
     *      max = 255,
     *      maxMessage = "le nom du département ne doit pas dépasser {{ limit }} caractères")
     */
    private $county;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="L'adresse mail est obligatoire")
     * @Assert\Length(
     *      min = 2,
     *      max = 255,
     *      minMessage = "Votre adresse mail doit être au moins {{ limit }} caractères de long",
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
    private $role;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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

    public function getCounty(): ?string
    {
        return $this->county;
    }

    public function setCounty(?string $county): self
    {
        $this->county = $county;

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

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

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
}

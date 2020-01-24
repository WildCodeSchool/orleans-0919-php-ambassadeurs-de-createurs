<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use \DateTime;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GalleryRepository")
 * @Vich\Uploadable
 */
class Gallery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $photoName;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     * @Vich\UploadableField(mapping="galleries_image", fileNameProperty="photoName")
     * @Assert\File(
     *     maxSize = "1M",
     *     maxSizeMessage="La taille des images est limité à {{ limit }} {{ suffix }}",
     *     mimeTypes = {"image/jpeg", "image/png", "image/webp", "image/gif"},
     *     mimeTypesMessage = "Ce n'est pas un format d'image valide"
     * )
     * @var File|null
     */
    private $photoFile;

    /**
     * @ORM\Column(type="datetime")
     * @var \DateTime
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Brand", inversedBy="galleries")
     * @ORM\JoinColumn(nullable=false)
     */
    private $galleryOwner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhotoName(): ?string
    {
        return $this->photoName;
    }

    public function setPhotoName(?string $photoName): self
    {
        $this->photoName = $photoName;

        return $this;
    }

    public function setUpdatedAt(DateTime $updatedAt): void
    {
        $this->updatedAt = $updatedAt;
    }

    public function getGalleryOWner(): ?Brand
    {
        return $this->galleryOwner;
    }

    public function setGalleryOWner(?Brand $brand): self
    {
        $this->galleryOwner = $brand;

        return $this;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photoFile
     */
    public function setPhotoFile(?File $photoFile = null): void
    {
        $this->photoFile = $photoFile;

        if (null !== $photoFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new DateTime();
        }
    }

    public function getPhotoFile(): ?File
    {
        return $this->photoFile;
    }
}

<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class PictureUploader
{
    private $targetDirectory;

    /**
     * PictureUploader constructor.
     * @param mixed $targetDirectory
     */
    public function __construct($targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function upload(UploadedFile $picture):string
    {
        $originalFilename = pathinfo($picture->getClientOriginalName() ?? 'picture', PATHINFO_FILENAME);
        $fileName = str_replace(' ', '_', $originalFilename).'-'.uniqid().'.'.$picture->guessExtension();
        $picture->move($this->getTargetDirectory(), $fileName);
        return $fileName;
    }

    /**
     * @return mixed
     */
    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }

    /**
     * @param mixed $targetDirectory
     */
    public function setTargetDirectory($targetDirectory): void
    {
        $this->targetDirectory = $targetDirectory;
    }
}

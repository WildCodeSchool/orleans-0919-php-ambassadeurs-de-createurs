<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\Gallery;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use \DateTime;

class GalleryFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 100; $i < 200; $i++) {
            $brand = $this->getReference('brand_' . $i);
            for ($j = 0; $j < 5; $j++) {
                $gallery = new Gallery();
                $gallery->setGalleryOWner($brand);
                $gallery->setUpdatedAt(new DateTime());
                $manager->persist($gallery);
            }
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ BrandFixtures::class];
    }
}

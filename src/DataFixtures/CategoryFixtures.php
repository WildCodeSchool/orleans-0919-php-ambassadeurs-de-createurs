<?php


namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    const CATEGORY = [
        'Mode',
        'Enfants',
        'Maison',
        'Beauté',
        'Gastronomie',
        'Autres',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORY as $key => $categoryDescription) {
            $category = new Category();
            $category->setDescription($categoryDescription);
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }
        $manager->flush();
    }
}

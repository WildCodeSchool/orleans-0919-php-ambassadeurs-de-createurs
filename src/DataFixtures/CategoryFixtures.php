<?php


namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

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
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $category = new Category();
            $category->setDescription($faker->sentence);
            $manager->persist($category);
        }

        foreach (self::CATEGORY as $key => $categoryDescription) {
            $category = new Category();
            $category->setDescription($categoryDescription);
            $manager->persist($category);
            $this->addReference('category_' . $key, $category);
        }
        $manager->flush();
    }
}

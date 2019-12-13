<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class BlogFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $blog = new Blog();
            $blog->setTitle($faker->sentence);
            $blog->setAuthor($faker->name);
            $blog->setContent($faker->paragraph(50));
            $blog->setDate($faker->dateTime);
            $manager->persist($blog);
        }
        $manager->flush();
    }
}

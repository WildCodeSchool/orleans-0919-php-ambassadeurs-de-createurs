<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class BlogFixtures extends Fixture implements DependentFixtureInterface
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
            $blog->setArticleTag($this->getReference('articleTag_' . rand(0, 1)));
            $manager->persist($blog);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [ArticleTagFixtures::class];
    }
}

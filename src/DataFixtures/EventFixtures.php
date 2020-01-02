<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EventFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 80; $i++) {
            $blog = new Event();
            $blog->setPlace($faker->city);
            $blog->setUser($this->getReference('USER_' . rand(0, 20)));
            $blog->setDescription($faker->sentence(6));
            $blog->setDateTime($faker->dateTime);
            $manager->persist($blog);
        }
        $manager->flush();
    }
}
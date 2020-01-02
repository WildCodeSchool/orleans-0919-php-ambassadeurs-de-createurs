<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');


        for ($i = 0; $i < 80; $i++) {
            $user = $this->getReference('user_' . rand(0, 19));
            $blog = new Event();
            $blog->setPlace($user->getCity());
            $blog->setUser($user);
            $blog->setDescription($faker->sentence(6));
            $blog->setDateTime($faker->dateTime);
            $manager->persist($blog);
        }
        $manager->flush();
    }

    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies()
    {
        return [ UserFixtures::class];
    }
}

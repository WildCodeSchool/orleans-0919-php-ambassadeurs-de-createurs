<?php


namespace App\DataFixtures;

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
            $brand = $this->getReference('brand_' . rand(20, 39));
            $event = new Event();
            $event->setPlace($user->getCity());
            $event->setLatitude($faker->latitude(-4.987792, 9.755859));
            $event->setLongitude($faker->longitude(41.046216, 51.563412));
            $event->setUser($user);
            $event->setBrand($brand);
            $event->setDescription($faker->sentence(6));
            $event->setDateTime($faker->dateTime);
            $manager->persist($event);
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
        return [ UserFixtures::class, BrandFixtures::class];
    }
}

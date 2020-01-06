<?php


namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Event;
use App\Service\CoordinateService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class EventFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $coordinateService = new CoordinateService();

        for ($i = 0; $i < 80; $i++) {
            $user = $this->getReference('user_' . rand(0, 19));
            $event = new Event();
            $event->setPlace($user->getCity());
            $coordinates = $coordinateService->getCoordinates($event->getPlace());
            $event->setLatitude($coordinates[0]);
            $event->setLongitude($coordinates[1]);
            $event->setUser($user);
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
        return [ UserFixtures::class];
    }
}

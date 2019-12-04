<?php

namespace App\DataFixtures;

use App\Entity\User;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $user = new User();
        $user->setFirstname($faker->firstName);
        $user->setLastname($faker->lastName);
        $user->setCity($faker->city);
        $user->setPicture($faker->imageUrl(200, 200, 'fashion'));
        $user->setMail($faker->email);
        $user->setRoles('Ambassadeur');

        $manager->persist($user);

        $manager->flush();
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\User;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setCity($faker->city);
            $user->setPicture($faker->imageUrl(200, 200, 'fashion'));
            $user->setMail($faker->email);
            $user->setRoles('Ambassadeur');
            $nbDuty = rand(0, 2);
            switch ($nbDuty) {
                case 0:
                    $user->addDuty($this->getReference('hôte'));
                    break;
                case 1:
                    $user->addDuty($this->getReference('vendeur'));
                    break;
                case 2:
                    $user->addDuty($this->getReference('hôte'));
                    $user->addDuty($this->getReference('vendeur'));
                    break;
            }
            $user->setDepartment($this->getReference("00" . rand(1, 7)));
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [DepartmentFixtures::class, DutyFixtures::class];
    }
}

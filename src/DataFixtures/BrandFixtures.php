<?php

namespace App\DataFixtures;

use App\Entity\Brand;
use App\Entity\User;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BrandFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 10; $i++) {
            $brand = new Brand();
            $brand->setName($faker->name);
            $brand->setDescription($faker->sentence(3));
            $brand->setSite($faker->url);
            $brand->setInstagram($faker->url);
            $brand->setHostAdvantage($faker->sentence(4));
            $brand->setSellerAdvantage($faker->sentence(4));
            $brand->setUser($this->getReference('user_' . rand(0, 19)));
            $manager->persist($brand);
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

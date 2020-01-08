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
        for ($i = 0; $i < 19; $i++) {
            $user = $this->getReference('user_' . $i);
            if ($user->getRoleLabel() == 'Créateur') {
                $brand = new Brand();
                $brand->setName($faker->name);
                $brand->setDescription($faker->paragraph(3));
                $brand->setSite($faker->url);
                $brand->setSellDescription($faker->paragraph(2));
                $brand->setInstagram($faker->url);
                $brand->setHostAdvantage($faker->sentence(2));
                $brand->setSellerAdvantage($faker->sentence(2));
                $brand->setUser($user);
                $manager->persist($brand);
            }
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
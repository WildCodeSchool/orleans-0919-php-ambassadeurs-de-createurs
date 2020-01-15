<?php

namespace App\DataFixtures;

use App\Entity\Favorite;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class FavoriteFixtures extends Fixture implements DependentFixtureInterface
{

    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $references = array_rand(range(100, 199), rand(2, 20));
            foreach ($references as $reference) {
                $favorite = new Favorite();
                $favorite->setUser($this->getReference('user_' . $i));
                $favorite->setUserFavorite($this->getReference('user_' . $reference));
                $manager->persist($favorite);
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

<?php

namespace App\DataFixtures;

use App\Entity\Department;
use App\Entity\Subscription;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class SubscriptionFixtures extends Fixture
{
    const PRICES = [
        "1 mois" => 15,
        "6 mois" => 10,
        "12 mois" => 8,
    ];

    public function load(ObjectManager $manager)
    {

        $subscription = new Subscription();
        $subscription->setOneMonth(self::PRICES["1 mois"]);
        $subscription->setSixMonth(self::PRICES["6 mois"]);
        $subscription->setOneYear(self::PRICES["12 mois"]);
        $manager->persist($subscription);

        $manager->flush();
    }
}

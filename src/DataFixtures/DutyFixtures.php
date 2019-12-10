<?php

namespace App\DataFixtures;

use App\Entity\Duty;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DutyFixtures extends Fixture
{
    const DUTIES = ['hôte', 'vendeur'];

    public function load(ObjectManager $manager)
    {
        foreach (self::DUTIES as $role) {
            $duty = new Duty();
            $duty->setName($role);
            $this->addReference($role, $duty);
            $manager->persist($duty);
        }
        $manager->flush();
    }
}

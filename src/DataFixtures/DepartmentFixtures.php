<?php

namespace App\DataFixtures;

use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture
{
    const DEPARTMENT = [
        "001" => "Ain",
        "002" => "Aisne",
        "003" => "Allier",
        "004" => "Basses-Alpes",
        "005" => "Hautes-Alpes",
        "006" => "Alpes-Maritimes",
        "007" => "Ardèche",
    ];
    public function load(ObjectManager $manager)
    {
        foreach (self::DEPARTMENT as $number => $name) {
            $department = new Department();
            $department->setCode($number);
            $department->setName($name);
            $this->addReference($number, $department);
            $manager->persist($department);
        }
        $manager->flush();
    }
}

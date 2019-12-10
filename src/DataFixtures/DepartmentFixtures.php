<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Department;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class DepartmentFixtures extends Fixture
{

    const CSV_FILE = 'assets/misc/departements-only-france.csv';

    public function load(ObjectManager $manager)
    {
        $departments = $this->readFileDepartment(self::CSV_FILE);
        array_pop($departments);
        $loopIndex = 1;
        foreach ($departments as $departmentCSV) {
            $department = new Department();
            $department->setCode($departmentCSV[1]);
            $department->setName($departmentCSV[2]);
            $this->addReference('department_'.$loopIndex, $department);
            $loopIndex++;
            $manager->persist($department);
        }
        $manager->flush();
    }

    public function readFileDepartment(string $file): array
    {
        $departments = [];
        $csvFile = fopen($file, "r");
        if ($csvFile != false) {
            while (!feof($csvFile)) {
                $departments[] = fgetcsv($csvFile, 1000, ",");
            }
        }
        fclose($csvFile);
        return $departments;
    }
}

<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Service\CoordinateService;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{
    const ROLES = [
        'ROLE_AMBASSADOR',
        'ROLE_CREATOR',
    ];

    const CITIES = [
        'Orleans',
        'Tours',
        'Chartres',
        'Blois',
        'Montargis',
        'Paris',
        'Lille',
        'Nantes',
        'Bordeaux',
        'Toulouse',
        'Nice',
    ];

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        $coordinateService = new CoordinateService();
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $city = self::CITIES[array_rand(self::CITIES)];
            $user->setCity($city);
            $coordinates = $coordinateService->getCoordinates($city);
            $user->setLatitude($coordinates[0]);
            $user->setLongitude($coordinates[1]);
            $user->setPicture($faker->imageUrl(200, 200, 'fashion'));
            $user->setMail($faker->email);
            $user->setRoles([self::ROLES[rand(0, 1)]]);
            $user->setDepartment($this->getReference("00" . rand(1, 7)));
            $user->addCategory($this->getReference('category_' . rand(0, 5)));
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
            $user->setUrlFacebook($faker->url);
            $user->setPassword($this->passwordEncoder->encodePassword(
                $user,
                'test'
            ));
            $this->addReference('user_' . $i, $user);
            $manager->persist($user);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [DepartmentFixtures::class, DutyFixtures::class];
    }
}

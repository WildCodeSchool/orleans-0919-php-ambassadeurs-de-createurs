<?php

namespace App\DataFixtures;

use App\Entity\User;
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
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 150; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $city = self::CITIES[array_rand(self::CITIES)];
            $user->setCity($city);
            $user->setLatitude($faker->latitude(-4.987792, 9.755859));
            $user->setLongitude($faker->longitude(41.046216, 51.563412));
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

        $admin = new User();
        $admin->setFirstname('admin');
        $admin->setLastname('admin');
        $admin->setCity('admin');
        $admin->setPicture('admin');
        $admin->setMail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setDepartment($this->getReference("00" . rand(1, 7)));
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));
        $manager->persist($admin);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [DepartmentFixtures::class, DutyFixtures::class];
    }
}

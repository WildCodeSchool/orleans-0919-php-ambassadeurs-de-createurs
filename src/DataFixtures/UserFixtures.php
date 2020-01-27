<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Repository\DepartmentRepository;
use App\Repository\DutyRepository;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use \DateTime;

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
    private $dutyRepository;
    private $departmentRepository;

    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        DutyRepository $dutyRepository,
        DepartmentRepository $departmentRepository
    ) {
        $this->passwordEncoder = $passwordEncoder;
        $this->dutyRepository = $dutyRepository;
        $this->departmentRepository = $departmentRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $duties = $this->dutyRepository->findAll();
        $departments = $this->departmentRepository->findAll();
        for ($i = 0; $i < 100; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $city = self::CITIES[array_rand(self::CITIES)];
            $user->setCity($city);
            $user->setLatitude($faker->latitude(-4.987792, 9.755859));
            $user->setLongitude($faker->longitude(41.046216, 51.563412));
            $user->setUpdatedAt(new DateTime());
            $user->setMail($faker->email);
            $user->setRoles([self::ROLES[0]]);
            $user->setDepartment($departments[array_rand($departments)]);
            $user->addCategory($this->getReference('category_' . rand(0, 5)));
            $nbDuty = rand(0, 2);
            switch ($nbDuty) {
                case 0:
                    $user->addDuty($duties[0]);
                    break;
                case 1:
                    $user->addDuty($duties[1]);
                    break;
                case 2:
                    $user->addDuty($duties[0]);
                    $user->addDuty($duties[1]);
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

        for ($i = 100; $i < 200; $i++) {
            $user = new User();
            $user->setFirstname($faker->firstName);
            $user->setLastname($faker->lastName);
            $user->setCity(self::CITIES[array_rand(self::CITIES)]);
            $user->setUpdatedAt(new DateTime());
            $user->setMail($faker->email);
            $user->setRoles([self::ROLES[1]]);
            $user->setDepartment($departments[array_rand($departments)]);
            $user->addCategory($this->getReference('category_' . rand(0, 5)));
            $nbDuty = rand(0, 2);
            switch ($nbDuty) {
                case 0:
                    $user->addDuty($duties[0]);
                    break;
                case 1:
                    $user->addDuty($duties[1]);
                    break;
                case 2:
                    $user->addDuty($duties[0]);
                    $user->addDuty($duties[1]);
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
        $admin->setUpdatedAt(new DateTime());
        $admin->setMail('admin@admin.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $user->setDepartment($departments[array_rand($departments)]);
        $admin->setPassword($this->passwordEncoder->encodePassword(
            $admin,
            'admin'
        ));
        $manager->persist($admin);

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
        return [ CategoryFixtures::class];
    }
}

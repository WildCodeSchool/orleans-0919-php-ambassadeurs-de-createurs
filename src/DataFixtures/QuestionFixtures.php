<?php

namespace App\DataFixtures;

use App\Entity\Question;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class QuestionFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        for ($i = 0; $i < 20; $i++) {
            $question = new Question();
            $question->setQuestion($faker->sentence);
            $question->setAnswer($faker->paragraph(12));
            $question->setCategory($this->getReference('questionCategory_' . rand(0, 2)));
            $manager->persist($question);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [QuestionCategoryFixtures::class];
    }
}

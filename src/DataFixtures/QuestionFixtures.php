<?php

namespace App\DataFixtures;

use App\Entity\Question;
use App\Repository\QuestionCategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class QuestionFixtures extends Fixture
{

    private $categoryRepository;
    /**
     * QuestionFixtures constructor.
     */
    public function __construct(QuestionCategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $categories = $this->categoryRepository->findAll();
        for ($i = 0; $i < 20; $i++) {
            $question = new Question();
            $question->setQuestion($faker->sentence);
            $question->setAnswer($faker->paragraph(12));
            $question->setCategory($categories[array_rand($categories)]);
            $manager->persist($question);
        }
        $manager->flush();
    }
}

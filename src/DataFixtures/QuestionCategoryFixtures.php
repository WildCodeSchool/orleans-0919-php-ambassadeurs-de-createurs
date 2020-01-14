<?php


namespace App\DataFixtures;

use App\Entity\QuestionCategory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class QuestionCategoryFixtures extends Fixture
{
    const CATEGORY = [
        'Général',
        'Fonctionnement du site',
        'Les différents onglets du site',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORY as $key => $category) {
            $questionCategory = new QuestionCategory();
            $questionCategory->setCategory($category);
            $this->addReference('questionCategory_' . $key, $questionCategory);
            $manager->persist($questionCategory);
        }
        $manager->flush();
    }
}

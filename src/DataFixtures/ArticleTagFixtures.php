<?php

namespace App\DataFixtures;

use App\Entity\ArticleTag;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class ArticleTagFixtures extends Fixture
{
    const TAG = [
        'Outil',
        'Interview',
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::TAG as $key => $tag) {
            $articleTag = new ArticleTag();
            $articleTag->setTag($tag);
            $this->addReference('articleTag_' . $key, $articleTag);
            $manager->persist($articleTag);
        }
        $manager->flush();
    }
}

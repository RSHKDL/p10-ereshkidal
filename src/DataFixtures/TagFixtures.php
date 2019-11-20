<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

class TagFixtures extends BaseFixture
{
    private static $tagNames = [
        'Dev',
        'Gaming',
        'Awesomeness',
        'Random',
        'Symfony',
        'C#'
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(Tag::class, 6, function (Tag $tag, int $count) {
            $tag->setName(self::$tagNames[$count]);
            $tag->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
        });
        $manager->flush();
    }
}

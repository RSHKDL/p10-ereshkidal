<?php

namespace App\DataFixtures;

use App\Entity\Tag;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class TagFixtures
 * @author ereshkidal
 */
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
        $this->createMany(6, 'main_tags', function (int $i) {
            $tag = new Tag();
            $tag->setName(self::$tagNames[$i]);
            $tag->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));

            return $tag;
        });
        $manager->flush();
    }
}

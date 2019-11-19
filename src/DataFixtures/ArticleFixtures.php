<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Generator;

/**
 * Class ArticleFixtures
 * @author ereshkidal
 */
class ArticleFixtures extends BaseFixture
{
    private static $articleTitles = [
        'What I like about PHP 8',
        'PSA: Docker is amazing',
        'Two years of formation. And a stage.',
    ];

    private static $articleImages = [
        'placeholder_img_1.jpg',
        'placeholder_img_3.jpg',
        'placeholder_img_4.jpg',
    ];

    /**
     * @param ObjectManager $manager
     */
    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(Article::class, 10, static function (Article $article, int $count, Generator $faker) {
            $article->setTitle($faker->randomElement(self::$articleTitles));
            $article->setSlug($faker->slug(8, true));
            $article->setContent($faker->realText());
            if ($faker->boolean(60)) {
                $article->setImageFilename($faker->randomElement(self::$articleImages));
            }
            $article->setHeartCount($faker->numberBetween(0, 99));
            if ($faker->boolean(70)) {
                $article->setPublishedAt($faker->dateTimeBetween('-60 days', '-1 days'));
            }
        });
        $manager->flush();
    }
}

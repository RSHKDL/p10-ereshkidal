<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\Persistence\ObjectManager;

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
        $this->createMany(Article::class, 10, function (Article $article, int $count) {
            $article->setTitle($this->faker->randomElement(self::$articleTitles));
            $article->setContent($this->faker->realText());
            if ($this->faker->boolean(60)) {
                $article->setImageFilename($this->faker->randomElement(self::$articleImages));
            }
            $article->setHeartCount($this->faker->numberBetween(0, 99));
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-60 days', '-1 days'));
            }
        });
        $manager->flush();
    }
}

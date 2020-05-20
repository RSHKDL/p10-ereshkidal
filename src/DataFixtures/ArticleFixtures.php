<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class ArticleFixtures
 * @author ereshkidal
 */
class ArticleFixtures extends BaseFixture implements DependentFixtureInterface
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [
            UserFixtures::class,
            TagFixtures::class
        ];
    }

    private static $articleTitles = [
        'What I like about PHP 8',
        'PSA: Docker is amazing',
        'Two years of formation. And a stage.',
        'Are all sheep electric?'
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
        $this->createMany(20, 'main_articles', function (int $i) {
            $article = new Article();
            $article->setTitle($this->faker->randomElement(self::$articleTitles));
            $article->setContent($this->faker->realText());
            $article->setAuthor($this->getRandomReference('main_users'));
            if ($this->faker->boolean(60)) {
                $article->setImageFilename($this->faker->randomElement(self::$articleImages));
            }
            $article->setHeartCount($this->faker->numberBetween(0, 99));
            if ($this->faker->boolean(70)) {
                $article->setPublishedAt($this->faker->dateTimeBetween('-3 months', '-1 days'));
            }
            $tags = $this->getRandomReferences('main_tags', $this->faker->numberBetween(1, 3));
            foreach ($tags as $tag) {
                $article->addTag($tag);
            }

            return $article;
        });
        $manager->flush();
    }
}

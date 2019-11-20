<?php

namespace App\DataFixtures;

use App\Entity\Article;
use App\Entity\Comment;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Class CommentFixtures
 * @author ereshkidal
 */
class CommentFixtures extends BaseFixture implements DependentFixtureInterface
{
    /**
     * This method must return an array of fixtures classes
     * on which the implementing class depends on
     *
     * @return array
     */
    public function getDependencies(): array
    {
        return [ArticleFixtures::class];
    }

    private static $authorNames = [
        'Ereshkidal',
        'Sinndrae',
        'Folkstorm',
        'NeeeKo',
        'Azo',
        'Rango',
        'Mimi'
    ];

    protected function loadData(ObjectManager $manager): void
    {
        $this->createMany(
            Comment::class,
            100,
            function(Comment $comment, int $count) {
                $comment->setContent($this->faker->boolean ? $this->faker->paragraph : $this->faker->sentences(2, true));
                $comment->setAuthor($this->faker->randomElement(self::$authorNames));
                $comment->setCreatedAt($this->faker->dateTimeBetween('-1 months', '-1 seconds'));
                /** @var Article $article */
                $article = $this->getRandomReference(Article::class);
                $comment->setArticle($article);
                $comment->setIsDeleted($this->faker->boolean(30));
        });
        $manager->flush();
    }
}

<?php

namespace App\Handler;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpFoundation\Session\Flash\FlashBagInterface;

/**
 * Class ArticleHandler
 * @author ereshkidal
 */
class ArticleHandler
{
    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * @var FlashBagInterface
     */
    private $flashBag;

    public function __construct(
        ArticleRepository $articleRepository,
        FlashBagInterface $flashBag
    ) {
        $this->articleRepository = $articleRepository;
        $this->flashBag = $flashBag;
    }

    /**
     * @param Article $article
     * @param string $publishOption
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function create(Article $article, string $publishOption): void
    {
        $message = 'Article scheduled for later';
        if ($publishOption === Article::STATUS_PUBLISHED) {
            $article->setPublishedAt(new \DateTime());
            $message = 'Article published';
        }
        if ($publishOption === Article::STATUS_DRAFT) {
            $article->setPublishedAt(null);
            $message = 'Draft saved';
        }
        $this->articleRepository->save($article);
        $this->flashBag->add('success', $message.'. A job well done.');
    }

    /**
     * @param Article $article
     * @param string $publishOption
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @throws \Exception
     */
    public function update(Article $article, string $publishOption): void
    {
        $message = 'Article scheduled for later';
        if ($publishOption === Article::STATUS_PUBLISHED && !$article->isPublished()) {
            $article->setPublishedAt(new \DateTime());
            $message = 'Article published';
        }
        if ($publishOption === Article::STATUS_PUBLISHED && $article->isPublished()) {
            $message = 'Approximations squashed';
        }
        if ($publishOption === Article::STATUS_DRAFT) {
            $article->setPublishedAt(null);
            $message = 'Draft saved';
        }
        $this->articleRepository->save($article);
        $this->flashBag->add('success', 'Article updated: '.$message.'.');
    }
}

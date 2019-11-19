<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ArticleController
 * @author ereshkidal
 */
class ArticleController extends AbstractController
{
    /**
     * @var bool
     */
    private $isDebug;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /***
     * ArticleController constructor.
     * @param bool $isDebug
     * @param ArticleRepository $articleRepository
     */
    public function __construct(bool $isDebug, ArticleRepository $articleRepository)
    {
        $this->isDebug = $isDebug;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/", name="app_homepage")
     */
    public function homepage(): Response
    {
        $articles = $this->articleRepository->findAllPublishedOrderedByNewest();

        return $this->render('article/index.html.twig', [
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/news/{slug}", name="article_show")
     * @param string $slug
     * @return Response
     */
    public function show(string $slug): Response
    {
        /** @var Article $article */
        $article = $this->articleRepository->findOneBy(['slug' => $slug]);
        if (!$article) {
            throw $this->createNotFoundException(sprintf('No article for slug "%s"', $slug));
        }

        return $this->render('article/show.html.twig', [
            'article' => $article
        ]);
    }

    /**
     * Not optimized for high-traffic system, race condition can occurs.
     *
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     * @param Article $article
     * @return JsonResponse
     * @throws \Exception
     */
    public function toggleArticleHeart(Article $article): JsonResponse
    {
        $article->incrementHeartCount();
        $this->articleRepository->update($article);

        return $this->json(['hearts' => $article->getHeartCount()]);
    }

    /**
     * @todo actually save the article in the db
     * @Route("/articles/create", name="article_create")
     */
    public function create()
    {
        $article = new Article();
        $this->articleRepository->save($article);
    }
}

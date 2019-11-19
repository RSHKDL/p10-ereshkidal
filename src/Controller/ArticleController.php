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
     * @todo use a database!
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
     * @todo actually heart/unheart the article!
     * @Route("/news/{slug}/heart", name="article_toggle_heart", methods={"POST"})
     * @param string $slug
     * @return JsonResponse
     * @throws \Exception
     */
    public function toggleArticleHeart(string $slug): JsonResponse
    {
        return $this->json(['hearts' => random_int(5, 100)]);
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

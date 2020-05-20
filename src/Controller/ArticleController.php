<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("/articles/create", name="article_create")
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function create(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(ArticleType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();
            $article->setAuthor($this->getUser());
            $this->articleRepository->save($article);

            $this->addFlash('success', 'Article created. A job well done.');

            return $this->redirectToRoute('admin_articles');
        }

        return $this->render('article/new.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/articles/{id}/update", name="article_update")
     * @param Article $article
     */
    public function update(Article $article)
    {
        $this->denyAccessUnlessGranted('MANAGE', $article);
        dd($article);
    }

    /**
     * @Route("/articles/{id}/delete", name="article_delete")
     * @param Article $article
     */
    public function delete(Article $article)
    {
        $this->denyAccessUnlessGranted('MANAGE', $article);
        dd($article);
    }
}

<?php

namespace App\Controller;

use App\Entity\Tag;
use App\Repository\ArticleRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class TagController
 * @author ereshkidal
 */
class TagController extends BaseController
{
    /**
     * @var TagRepository
     */
    private $tagRepository;

    /**
     * @var ArticleRepository
     */
    private $articleRepository;

    /**
     * TagController constructor.
     * @param TagRepository $tagRepository
     * @param ArticleRepository $articleRepository
     */
    public function __construct(TagRepository $tagRepository, ArticleRepository  $articleRepository)
    {
        $this->tagRepository = $tagRepository;
        $this->articleRepository = $articleRepository;
    }

    /**
     * @Route("/dashboard/tag/{slug}", name="tag_manage")
     * @param Tag $tag
     * @return Response
     */
    public function manageTag(Tag $tag): Response
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        return $this->render('admin/tags_show.html.twig', [
            'tag' => $tag
        ]);
    }

    /**
     * @Route("/tag/{slug}", name="tag_show")
     * @param Tag $tag
     * @return Response
     */
    public function show(Tag $tag): Response
    {
        dd('oops: todo');
        return $this->render('tag/show.html.twig', [
            'tag' => $tag
        ]);
    }

    /**
     * @Route("tag/{tagId}/article/{articleId}", name="remove_article_from_tag", methods={"DELETE"})
     * @param int $tagId
     * @param int $articleId
     * @return Response
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function removeArticleFromTag(int $tagId, int $articleId): Response
    {
        $this->denyAccessUnlessGranted("ROLE_ADMIN");

        $tag = $this->tagRepository->find($tagId);
        if (!$tag) {
            throw $this->createNotFoundException('tag not found');
        }

        $article = $this->articleRepository->find($articleId);
        if (!$article) {
            throw $this->createNotFoundException('article not found');
        }

        $tag->removeArticle($article);
        $this->tagRepository->update($tag);

        return new Response(null, 204);
    }
}

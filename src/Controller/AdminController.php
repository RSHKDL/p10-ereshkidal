<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @var PaginatorInterface
     */
    private $paginator;

    public function __construct(PaginatorInterface $paginator)
    {
        $this->paginator = $paginator;
    }

    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
        ]);
    }

    /**
     * @Route("/admin/articles", name="admin_articles")
     * @param Request $request
     * @param ArticleRepository $repository
     * @return Response
     */
    public function manageArticles(Request $request, ArticleRepository $repository): Response
    {
        $pagination = $this->paginator->paginate(
            $repository->createQueryBuilder('a'),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/articles.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/admin/comments", name="admin_comments")
     * @param Request $request
     * @param CommentRepository $repository
     * @return Response
     */
    public function manageComments(Request $request, CommentRepository $repository): Response
    {
        $term = $request->query->get('q');
        $queryBuilder = $repository->getQueryBuilderWithFilter($term);
        $pagination = $this->paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/comments.html.twig', [
            'pagination' => $pagination
        ]);
    }
}

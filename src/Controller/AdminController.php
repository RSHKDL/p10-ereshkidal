<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CommentRepository;
use App\Repository\AbstractReportRepository;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @author ereshkidal
 *
 * @IsGranted("ROLE_USER")
 */
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
     * @Route("/dashboard", name="admin_dashboard")
     */
    public function dashboard(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    /**
     * @Route("/dashboard/articles", name="admin_articles")
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
     * @Route("/dashboard/comments", name="admin_comments")
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

    /**
     * @Route("/dashboard/reports", name="admin_reports")
     * @param Request $request
     * @param AbstractReportRepository $repository
     * @return Response
     */
    public function manageReports(Request $request, AbstractReportRepository $repository): Response
    {
        $pagination = $this->paginator->paginate(
            $repository->createQueryBuilder('r'),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/reports.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * @Route("/dashboard/account", name="admin_account")
     */
    public function manageAccount(): Response
    {
        $user = $this->getUser();

        return $this->render('admin/account.html.twig', [
            'user' => $user
        ]);
    }
}

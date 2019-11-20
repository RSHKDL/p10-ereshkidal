<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
        ]);
    }

    /**
     * @Route("/admin/comments", name="admin_comments")
     * @param CommentRepository $repository
     * @return Response
     */
    public function manageComments(
        CommentRepository $repository,
        Request $request,
        PaginatorInterface $paginator
    ): Response {
        $term = $request->query->get('q');
        $queryBuilder = $repository->getQueryBuilderWithFilter($term);
        $pagination = $paginator->paginate(
            $queryBuilder,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('admin/comments.html.twig', [
            'pagination' => $pagination
        ]);
    }
}

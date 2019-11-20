<?php

namespace App\Controller;

use App\Repository\CommentRepository;
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
    public function manageComments(CommentRepository $repository, Request $request): Response
    {
        $term = $request->query->get('q');
        $comments = $repository->findAllWithFilter($term);

        return $this->render('admin/comments.html.twig', [
            'comments' => $comments
        ]);
    }
}

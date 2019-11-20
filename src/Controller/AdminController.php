<?php

namespace App\Controller;

use App\Repository\CommentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function manageComments(CommentRepository $repository): Response
    {
        $comments = $repository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('admin/comments.html.twig', [
            'comments' => $comments
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AccountController
 * @author ereshkidal
 */
class AccountController extends BaseController
{
    /**
     * @Route("/account", name="app_account")
     */
    public function index(): Response
    {
        $user = $this->getUser();

        return $this->render('account/index.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/api/account", name="api_account")
     */
    public function accountApi(): JsonResponse
    {
        $user = $this->getUser();

        if (!$user) {
            throw new NotFoundHttpException();
        }

        return $this->json($user, Response::HTTP_OK, [], [
            'groups' => ['main']
        ]);
    }
}

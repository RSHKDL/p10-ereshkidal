<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 * @author ereshkidal
 */
class ProfileController extends BaseController
{
    /**
     * @Route("/profile/{id}", name="app_profile")
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return $this->render('profile/show.html.twig', [
            'user' => $user,
        ]);
    }

    /**
     * @Route("/api/profile", name="api_profile")
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

<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardUtilityController extends AbstractController
{
    /**
     * @Route("/api/utility/users", name="api_utility_users", methods={"GET"})
     * @param UserRepository $userRepository
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsersApi(UserRepository $userRepository, Request $request): JsonResponse
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $users = $userRepository->findAllMatching($request->query->get('query'));

        return $this->json(
            ['users' => $users],
            Response::HTTP_OK,
            [],
            ['groups' => ['main']]
        );
    }
}

<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
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
}

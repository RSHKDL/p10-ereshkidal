<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class SecurityController
 * @author ereshkidal
 */
class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error' => $error
        ]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
    }

    /**
     * @Route("/register", name="app_register")
     * @param Request $request
     * @param UserRepository $userRepository
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     * @param GuardAuthenticatorHandler $guardAuthenticatorHandler
     * @param LoginFormAuthenticator $loginFormAuthenticator
     * @return Response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     * @todo use symfony form and validation
     */
    public function register(
        Request $request,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $userPasswordEncoder,
        GuardAuthenticatorHandler $guardAuthenticatorHandler,
        LoginFormAuthenticator $loginFormAuthenticator
    ): Response {
        if ($request->isMethod('POST')) {
            $user = new User();
            $user->setEmail($request->request->get('email'));
            $user->setUsername('fake_username');
            $user->setPassword($userPasswordEncoder->encodePassword(
                $user,
                $request->request->get('password')
            ));

            $userRepository->save($user);

            return $guardAuthenticatorHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $loginFormAuthenticator,
                'main'
            );
        }

        return $this->render('security/register.html.twig');
    }
}

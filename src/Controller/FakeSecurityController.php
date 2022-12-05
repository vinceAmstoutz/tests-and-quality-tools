<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

final class FakeSecurityController extends AbstractController
{
    #[Route('/auth', name: 'app_auth')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('fake_security/index.html.twig', [
            'controller_name' => 'FakeSecurityController',
        ]);
    }

    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_auth');
        }

        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render(
            'fake_security/login.html.twig',
            ['last_username' => $lastUsername, 'error' => $error]
        );
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
    }

    #[Route('/admin', name: 'app_admin')]
    #[IsGranted('ROLE_ADMIN')]
    public function adminIndex(): Response
    {
        return $this->render('fake_security/admin/index.html.twig', [
            'controller_name' => 'FakeSecurityController',
        ]);
    }
}

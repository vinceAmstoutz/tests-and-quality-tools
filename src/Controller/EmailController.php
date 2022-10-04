<?php

namespace App\Controller;

use App\Services\Checker\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Email as MimeEmail;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailController extends AbstractController
{
    #[Route('/check-email/{email}', name: 'email_check')]
    public function checkEmail(string $email, Email $emailChecker, MailerInterface $mailer): Response
    {
        $isValidEmail = $emailChecker->ensureIsValidEmail($email);

        return $this->render('email/index.html.twig', [
            'controller_name' => 'EmailController',
            'isValidEmail' => $isValidEmail
        ]);
    }
}

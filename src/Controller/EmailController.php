<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class EmailController extends AbstractController
{
    #[Route('/email/send', name: 'app_email_send')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('test.user@app.com')
            ->to('test.admin@app.com')
            ->html('Hello admin! Enjoy this email :)');
        $mailer->send($email);

        return new Response("Email sent!");
    }
}

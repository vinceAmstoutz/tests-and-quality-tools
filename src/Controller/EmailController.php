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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

final class EmailController extends AbstractController
{
    #[Route('/email/send', name: 'app_email_send')]
    public function index(MailerInterface $mailer): Response
    {
        $email = (new Email())
            ->from('test.user@app.com')
            ->to('test.admin@app.com')
            ->html('Hello admin! Enjoy this email :)');
        $mailer->send($email);

        return new Response('Email sent!');
    }
}

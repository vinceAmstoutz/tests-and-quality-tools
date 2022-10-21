<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use Symfony\Component\Mime\Email;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private MailerInterface $mailer;
    private string $from;
    private string $to;

    public function create(MailerInterface $mailer, string $from, string $to): ExceptionSubscriber
    {
        $this->mailer = $mailer;
        $this->from = $from;
        $this->to = $to;

        return $this;
    }

    public function onException(ExceptionEvent $event): void
    {
        $email = (new Email())
            ->from($this->from)
            ->to($this->to)
            ->text("{$event->getRequest()->getRequestUri()}
                {$event->getThrowable()->getMessage()}
                {$event->getThrowable()->getTraceAsString()}");

        $this->mailer->send($email);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ExceptionEvent::class => 'onException',
        ];
    }
}

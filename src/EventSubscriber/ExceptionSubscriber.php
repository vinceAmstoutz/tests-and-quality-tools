<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ExceptionSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private MailerInterface $mailer,
        private string $from,
        private string $to
    ) {
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

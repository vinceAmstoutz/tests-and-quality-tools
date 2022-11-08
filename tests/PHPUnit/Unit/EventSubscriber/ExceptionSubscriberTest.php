<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Unit\EventSubscriber;

use App\EventSubscriber\ExceptionSubscriber;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ExceptionSubscriberTest extends TestCase
{
    public function testEventSubscription(): void
    {
        $this->assertArrayHasKey(ExceptionEvent::class, ExceptionSubscriber::getSubscribedEvents());
    }

    public function testOnExceptionSendEmail(): void
    {
        $mailer = $this->createMailerMock();
        $mailer->expects($this->once())
            ->method('send');

        $this->dispatch($mailer);
    }

    public function testOnExceptionSendWithTheTrace(): void
    {
        $mailer = $this->createMailerMock();
        $mailer->expects($this->once())
            ->method('send')
            ->with(
                $this->callback(function (Email $email) {
                    return
                        str_contains($email->getTextBody(), 'ExceptionSubscriberTest')
                        && str_contains($email->getTextBody(), 'Hello error');
                })
            );
        $this->dispatch($mailer);
    }

    private function createMailerMock(): MailerInterface|MockObject
    {
        return $this->getMockBuilder(MailerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function dispatch(MailerInterface|MockObject $mailer): void
    {
        $subscriber = new ExceptionSubscriber(
            $mailer,
            'app@domain.com',
            'admin@domain.com'
        );

        /**
         * @var KernelInterface
         */
        $httpKernel = $this->getMockBuilder(KernelInterface::class)
            ->getMock();

        $event = new ExceptionEvent($httpKernel, new Request(), 1, new \Exception('Hello error'));

        $mailer->expects($this->once())->method('send');

        // $subscriber->onException($event);
        // MUST use a dispatcher, as below, to also check if the method exist
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);
        $dispatcher->dispatch($event);
    }
}

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
        /** @var MockObject */
        $mailer = $this->createMailerMock();
        $mailer->expects($this->once())
            ->method('send');

        $this->dispatch($mailer);
    }

    public function testOnExceptionSendWithTheTrace(): void
    {
        /** @var MockObject */
        $mailer = $this->createMailerMock();
        $mailer->expects($this->once())
            ->method('send')
            ->with(
                $this->callback(function (Email $email) {
                    return
                        str_contains((string) $email->getTextBody(), 'ExceptionSubscriberTest')
                        && str_contains((string) $email->getTextBody(), 'Hello error');
                })
            );
        $this->dispatch($mailer);
    }

    private function createMailerMock(): MockObject
    {
        return $this->getMockBuilder(MailerInterface::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    private function dispatch(MockObject $mailer): void
    {
        /** @var MockObject */
        $mailerMock = clone $mailer;

        /** @var MailerInterface $mailer */
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

        $mailerMock->expects($this->once())->method('send');

        // $subscriber->onException($event);
        // MUST use a dispatcher, as below, to also check if the method exist
        $dispatcher = new EventDispatcher();
        $dispatcher->addSubscriber($subscriber);
        $dispatcher->dispatch($event);
    }
}

<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Mime\RawMessage;

class EmailControllerTest extends WebTestCase
{
    public function testMailIsSentAndContentIsOk(): void
    {
        $this->sendEmail();
        $this->assertResponseIsSuccessful();

        /** @var RawMessage */
        $email = $this->getMailerMessage();
        $this->assertEmailHtmlBodyContains($email, 'Hello');
    }

    public function testEmailParticipants(): void
    {
        $this->sendEmail();
        $this->assertResponseIsSuccessful();

        /** @var RawMessage */
        $email = $this->getMailerMessage();
        $this->assertEmailAddressContains($email, 'from', 'test.user@app.com');
        $this->assertEmailAddressContains($email, 'to', 'test.admin@app.com');
    }

    public function sendEmail(): void
    {
        $client = $this->createClient();
        $client->request('GET', '/email/send');
    }
}

<?php

namespace App\Tests\Controller;

use Symfony\Component\Panther\PantherTestCase;

class ContactControllerTest extends PantherTestCase
{
    public function testSomething(): void
    {
        $client = static::createPantherClient();
        $client->request('GET', '/');

        $this->assertSelectorTextContains('h1', 'Hello world');
    }
}

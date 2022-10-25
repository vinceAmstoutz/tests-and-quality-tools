<?php

namespace App\Tests\PHPUnit\EndToEnd\Controller;

use Symfony\Component\Panther\PantherTestCase;

class HomepageControllerTest extends PantherTestCase
{
    public function testHomepageContent(): void
    {
        $client = static::createPantherClient();
        $client->request('GET', '/');

        $this->assertSelectorTextContains('h1', 'Hello world');
    }
}

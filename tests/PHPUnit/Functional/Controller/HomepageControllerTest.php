<?php

declare(strict_types=1);

namespace App\Tests\PHPUnit\Functional\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomepageControllerTest extends WebTestCase
{
    public function testHomepagePage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
    }

    public function testH1HomepagePage(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSelectorTextSame('h1', 'Hello world');
    }
}

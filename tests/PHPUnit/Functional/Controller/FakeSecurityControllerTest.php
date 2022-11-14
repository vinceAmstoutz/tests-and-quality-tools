<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Functional\Controller;

use App\Tests\PHPUnit\Functional\Trait\LoginConnectionTrait;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class FakeSecurityControllerTest extends WebTestCase
{
    use LoginConnectionTrait;

    public function testAccessDeniedForAnonymousUsers(): void
    {
        $client = static::createClient();
        $client->request('GET', '/auth');

        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
    }

    /**
     * @dataProvider getLoginFormMinimalRequired
     */
    public function testDisplayPlainLoginFormContent(string $query): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $this->assertSelectorTextContains('h1', 'Please sign in');
        $this->assertSelectorExists($query);
        $this->assertSelectorNotExists('.alert.alert-danger');
    }

    public function getLoginFormMinimalRequired(): \Generator
    {
        yield ['body form[method="post"]'];
        yield ['form input[type="email"][required]'];
        yield ['form input[type="password"][required]'];
        yield ['form input[type="hidden"][name="_csrf_token"]'];
        yield ['form button[type="submit"]'];
    }

    /**
     * Never working if we have a frontend DOM override
     * (use e2e tests instead)!
     */
    public function testLoginWithBadCredentials(): void
    {
        $client = static::createClient();
        $client->request('GET', '/login');

        $client->submitForm(
            'Sign in',
            [
                'email' => 'john.doe@domain.fr',
                'password' => 'fake_insecure_passwd',
            ],
            Request::METHOD_POST
        );

        $this->assertResponseRedirects('/login', Response::HTTP_FOUND);
        $client->followRedirect();
        $this->assertSelectorExists('.alert.alert-danger');
    }

    public function testSuccessfulLogin(): void
    {
        $client = static::createClient();

        $this->login($client);

        $client->request('GET', '/auth');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello test.user@app.com!');
    }

    public function testRedirectAuthenticatedUser(): void
    {
        $client = static::createClient();

        $this->login($client);

        $client->request('GET', '/login');
        $this->assertResponseRedirects('/auth', Response::HTTP_FOUND);
    }

    public function testAdminAccessWithUnSufficientRole(): void
    {
        $client = static::createClient();

        $this->login($client, 'user_test');

        $client->request('GET', '/admin');
        $this->assertResponseStatusCodeSame(Response::HTTP_FORBIDDEN);
    }

    public function testAdminAccessWithSufficientRole(): void
    {
        $client = static::createClient();

        $this->login($client, 'user_admin');

        $client->request('GET', '/admin');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello admin test.admin@app.com!');
    }

    public function testLogoutWhenConnected(): void
    {
        $client = static::createClient();

        $this->login($client, 'user_admin');
        $client->request('GET', 'logout');
        $this->assertResponseRedirects('http://localhost/', Response::HTTP_FOUND);
    }

    public function testLogoutWhenNotConnected(): void
    {
        $client = static::createClient();

        $client->request('GET', 'logout');
        $this->assertResponseRedirects('http://localhost/', Response::HTTP_FOUND);
    }
}

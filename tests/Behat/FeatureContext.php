<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\Behat;

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use PHPUnit\Framework\Assert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;

final class FeatureContext extends MinkContext implements Context
{
    /** @var KernelInterface */
    private $kernel;

    /** @var Response|null */
    private $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @When a demo scenario sends a request to :path
     */
    public function aDemoScenarioSendsARequestTo(string $path): void
    {
        $this->response = $this->kernel->handle(Request::create($path, 'GET'));
    }

    /**
     * @Then the response should be received
     */
    public function theResponseShouldBeReceived(): void
    {
        Assert::assertNotNull($this->response, 'No response received');
    }

    /**
     * @Then the response should be successful
     */
    public function theResponseShouldBeSuccessful(): void
    {
        if (!$this->response->isSuccessful()) {
            throw new \RuntimeException('Incorrect response');
        }
    }
}

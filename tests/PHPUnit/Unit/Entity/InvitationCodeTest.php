<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Unit\Entity;

use App\Entity\InvitationCode;
use App\Tests\PHPUnit\Unit\Trait\ErrorTrait;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class InvitationCodeTest extends KernelTestCase
{
    use ErrorTrait;

    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    protected function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function getEntity(): InvitationCode
    {
        return (new InvitationCode())
            ->setCode('12345')
            ->setDescription('Test description')
            ->setExpireAt(new \DateTimeImmutable());
    }

    public function testValidEntity(): void
    {
        $this->assertHasError($this->getEntity()->setCode('1234'), 1);
    }

    public function testInvalidEntity(): void
    {
        $this->assertHasError($this->getEntity()->setCode('1a345'), 1);
        $this->assertHasError($this->getEntity()->setCode('1345'), 1);
    }

    public function testInvalidBlankCodeEntity(): void
    {
        $this->assertHasError($this->getEntity()->setCode(''), 1);
    }

    public function testInvalidBlankDescription(): void
    {
        $this->assertHasError($this->getEntity()->setDescription(''), 1);
    }

    public function testDuplicateCode(): void
    {
        $this->databaseTool->loadAliceFixture([
            \dirname(__DIR__, 2).'/YamlFixtures/invitation_codes.yaml',
        ]);

        $this->assertHasError($this->getEntity()->setCode('54321'), 1);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}

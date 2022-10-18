<?php

declare(strict_types=1);

namespace App\Tests\Entity;

use DateTimeImmutable;
use App\Entity\InvitationCode;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Liip\TestFixturesBundle\Services\DatabaseTools\AbstractDatabaseTool;
use Symfony\Component\Validator\ConstraintViolation;

class InvitationCodeTest extends KernelTestCase
{
    /** @var AbstractDatabaseTool */
    protected $databaseTool;

    public function setUp(): void
    {
        parent::setUp();

        $this->databaseTool = static::getContainer()->get(DatabaseToolCollection::class)->get();
    }

    public function getEntity(): InvitationCode
    {
        return (new InvitationCode())
            ->setCode('12345')
            ->setDescription('Test description')
            ->setExpireAt(new DateTimeImmutable());
    }

    //TODO: put in a trait !
    public function assertHasError(InvitationCode $code, int $expected = 0)
    {
        $messages = [];
        self::bootKernel();

        $errors = static::getContainer()->get('validator')->validate($code);

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($expected, $errors, implode(',', $messages));
    }

    public function testValidEntity(): void
    {
        $this->assertHasError($this->getEntity()->setCode('1234'), 0);
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

    public function testDuplicateCode()
    {
        $this->databaseTool->loadAliceFixture([
            dirname(__DIR__) . '/fixtures/invitation_codes.yaml',
        ]);

        $this->assertHasError($this->getEntity()->setCode('54321'), 1);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->databaseTool);
    }
}

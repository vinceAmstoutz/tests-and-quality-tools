<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Tests\ErrorTrait;
use App\Validator\EmailDomain;
use App\Validator\EmailDomainValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class EmailDomainValidatorTest extends ConstraintValidatorTestCase
{
    use ErrorTrait;

    protected function createValidator()
    {
        return new EmailDomainValidator();
    }

    /**
     * @dataProvider provideInvalidConstraints
     */
    public function testCatchAcceptedDomains(EmailDomain $constraint): void
    {
        $this->validator->validate('demo@outlook.com', $constraint);
        $this->assertNoViolation();
    }

    /**
     * @dataProvider provideInvalidConstraints
     */
    public function testCatchBadDomains(EmailDomain $constraint): void
    {
        $value = 'demo@baddomain.com';

        $this->validator->validate($value, $constraint);

        $this->assertEquals($this->context->getViolations()->count(), 1);
    }

    /**
     * @return array<array, string>
     */
    public function getStaticDomainBlackList(): array
    {
        return ['blocked' => [
            'yopmail.com',
            'yoopala.com',
            'baddomain.com'
        ]];
    }

    public function provideInvalidConstraints(): iterable
    {
        yield [new EmailDomain($this->getStaticDomainBlackList())];
    }
}

<?php

declare(strict_types=1);

namespace App\Tests\PHPUnit\Unit\Validator;

use App\Validator\EmailDomain;
use App\Validator\EmailDomainValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;

class EmailDomainValidatorTest extends ConstraintValidatorTestCase
{
    protected function createValidator(): EmailDomainValidator
    {
        return new EmailDomainValidator();
    }

    /**
     * @dataProvider provideInvalidConstraints
     */
    public function testValidateOnNull(EmailDomain $constraint): void
    {
        $validation = $this->validator->validate(null, $constraint);
        $this->assertEquals(null, $validation);
    }

    /**
     * @dataProvider provideInvalidConstraints
     */
    public function testValidateUsageOnEmptyString(EmailDomain $constraint): void
    {
        $validation = $this->validator->validate('', $constraint);
        $this->assertEquals(null, $validation);
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
     * @return array<array <string>>
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

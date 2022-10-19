<?php

declare(strict_types=1);

namespace App\Tests\Validator;

use App\Validator\EmailDomain;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\MissingOptionsException;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

class EmailDomainTest extends TestCase
{
    public function testRequiredParameters(): void
    {
        $this->expectException(MissingOptionsException::class);
        new EmailDomain();
    }

    public function testBadShapeBlockedParameter(): void
    {
        $this->expectException(ConstraintDefinitionException::class);
        new EmailDomain(['blocked' => 'yopmail.com']);
    }

    public function testOptionIsSetAsProperty(): void
    {
        $blackList = [
            'yopmail.com',
            'yoopala.com',
        ];

        $domain = new EmailDomain(['blocked' => $blackList]);
        $this->assertEquals($blackList, $domain->blocked);
    }
}

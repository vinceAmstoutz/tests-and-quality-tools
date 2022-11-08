<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Unit\Validator;

use App\Validator\EmailDomain;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;
use Symfony\Component\Validator\Exception\MissingOptionsException;

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
        $this->assertSame($blackList, $domain->blocked);
    }
}

<?php

declare(strict_types=1);

namespace App\Tests;

use PHPUnit\Framework\TestCase;

class AppTest extends TestCase
{
    public function testTestAreWorking(): void
    {
        $this->assertEquals(2, 1 + 1);
    }
}
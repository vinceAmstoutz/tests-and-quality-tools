<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Unit\Repository;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    public function testCount(): void
    {
        self::bootKernel();
        $container = static::getContainer();
        /** @var UserRepository */
        $users = $container->get(UserRepository::class);
        $this->assertSame(10, $users->count([]));
    }
}

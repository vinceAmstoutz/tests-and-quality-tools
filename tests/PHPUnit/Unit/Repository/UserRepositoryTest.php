<?php

declare(strict_types=1);

namespace App\Tests\PHPUnit\Unit\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserRepositoryTest extends KernelTestCase
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    protected function setUp(): void
    {
        $kernel =
            self::bootKernel([
                'environment' => 'test',
                'debug'       => false,
            ]);

        $this->entityManager = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function testCount(): void
    {
        $users = $this->entityManager->getRepository(User::class)->count([]);
        $this->assertEquals(10, $users);
    }

    protected function tearDown(): void
    {
        parent::tearDown();

        //recommended to avoid memory leaks
        $this->entityManager->close();
        $this->entityManager = null;
    }
}

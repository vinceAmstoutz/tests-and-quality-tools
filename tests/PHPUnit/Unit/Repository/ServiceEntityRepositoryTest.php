<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Unit\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Entity;
use Exception;
use PHPUnit\Framework\MockObject\MockObject;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Allow to test if remove and save methods are presents in repositories.
 */
class ServiceEntityRepositoryTest extends KernelTestCase
{
    private EntityManager $em;

    protected function setUp(): void
    {
        $kernel =
            self::bootKernel([
                'environment' => 'test',
                'debug' => false,
            ]);

        $this->em = $kernel->getContainer()
            ->get('doctrine')
            ->getManager();
    }

    public function getEntitiesNameList(): array
    {
        return $this->em
            ->getConfiguration()
            ->getMetadataDriverImpl()
            ->getAllClassNames();
    }

    public function testSaveEntityWithoutFlush(): void
    {
        $entities = $this->getEntitiesNameList();
        $this->assertNotEmpty($entities, 'No entities!');

        foreach ($entities as $entity) {
            if (class_exists($entity)) {
                $entityRepositoryMock = $this->getEntityRepositoryMock($entity);

                $this->assertEntityRepositoryHasMethod(
                    $entityRepositoryMock,
                    $entity,
                    method: 'save'
                );

                $entityTest = new $entity();
                $entityRepositoryMock->save($entityTest);
            }
        }
    }

    public function testSaveEntityWithFlush(): void
    {
        $entities = $this->getEntitiesNameList();
        $this->assertNotEmpty($entities, 'No entities!');

        foreach ($entities as $entity) {
            if (class_exists($entity)) {
                $entityRepositoryMock = $this->getEntityRepositoryMock($entity);

                $this->assertEntityRepositoryHasMethod(
                    $entityRepositoryMock,
                    $entity,
                    method: 'save',
                    isFlush: true
                );

                $entityTest = new $entity();
                $entityRepositoryMock->save($entityTest, true);
            }
        }
    }

    public function testRemoveEntityWithoutFlush(): void
    {
        $entities = $this->getEntitiesNameList();
        $this->assertNotEmpty($entities, 'No entities!');

        foreach ($entities as $entity) {
            if (class_exists($entity)) {
                $entityRepositoryMock = $this->getEntityRepositoryMock($entity);

                $this->assertEntityRepositoryHasMethod(
                    $entityRepositoryMock,
                    $entity,
                    method: 'remove'
                );

                $entityTest = new $entity();
                $entityRepositoryMock->remove($entityTest);
            }
        }
    }

    public function testRemoveEntityWithFlush(): void
    {
        $entities = $this->getEntitiesNameList();
        $this->assertNotEmpty($entities, 'No entities!');

        foreach ($entities as $entity) {
            if (class_exists($entity)) {
                $entityRepositoryMock = $this->getEntityRepositoryMock($entity);

                $this->assertEntityRepositoryHasMethod(
                    $entityRepositoryMock,
                    $entity,
                    method: 'remove',
                    isFlush: true
                );

                $entityTest = new $entity();
                $entityRepositoryMock->remove($entityTest, true);
            }
        }
    }

    public function getEntityRepositoryMock(mixed $entity): MockObject|Entity
    {
        $entityRepository = \get_class($this->em->getRepository($entity));

        return $this->getMockBuilder($entityRepository)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function assertEntityRepositoryHasMethod(
        MockObject $entityRepositoryMock,
        mixed $entity,
        string $method,
        bool $isFlush = null
    ) {
        try {
            $entityRepositoryMock->expects($this->once())
                ->method($method)
                ->with(new $entity(), $isFlush);
        } catch (Exception) {
            $this->fail($entity.' repository\'s doesn\'t have a '.$method.' method! You MUST implement it!');
        }
    }

    public function isFlush(bool $isFlush): bool
    {
        return isset($isFlush) && false !== $isFlush ?? $isFlush;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($this->em);
    }
}

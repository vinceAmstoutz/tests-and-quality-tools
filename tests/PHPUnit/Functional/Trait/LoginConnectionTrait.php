<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Functional\Trait;

use App\Entity\User;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;

trait LoginConnectionTrait
{
    public function login(KernelBrowser $client, string $user = 'user_test'): void
    {
        /** @var DatabaseToolCollection $databaseCollection */
        $databaseCollection = static::getContainer()->get(DatabaseToolCollection::class);
        $usersFixtures = $databaseCollection
            ->get()->loadAliceFixture([
                \dirname(__DIR__, 2).'/YamlFixtures/users.yaml',
            ]);

        /** @var User */
        $testUser = $usersFixtures[$user];

        // simulate $testUser being logged in
        $client->loginUser($testUser);
    }
}

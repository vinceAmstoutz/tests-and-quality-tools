<?php

declare(strict_types=1);

namespace App\Tests\PHPUnit\Functional\Trait;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Liip\TestFixturesBundle\Services\DatabaseToolCollection;

trait LoginConnectionTrait
{
    public function login(KernelBrowser $client, string $user = 'user_test'): void
    {
        $usersFixtures = static::getContainer()
            ->get(DatabaseToolCollection::class)
            ->get()->loadAliceFixture([
                dirname(__DIR__, 2) . '/YamlFixtures/users.yaml',
            ]);

        /** @var User */
        $testUser = $usersFixtures[$user];

        // simulate $testUser being logged in
        $client->loginUser($testUser);
    }
}

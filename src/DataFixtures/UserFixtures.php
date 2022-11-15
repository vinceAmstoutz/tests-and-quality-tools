<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory as FakerFactory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * @codeCoverageIgnore
     */
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        $admin = (new User())
                ->setEmail('admin@domain.com')
                ->setRoles(['ROLE_ADMIN']);
        $this->setHashedPassword($admin, 'not-secured-admin-pass');

        $manager->persist($admin);

        for ($i = 0; $i < 9; ++$i) {
            $user = (new User())
                ->setEmail($faker->email())
                ->setRoles(['ROLE_USER']);
            $this->setHashedPassword($user, $faker->password(8, 18));

            $manager->persist($user);
        }
        $manager->flush();
    }

    public function setHashedPassword(User $user, string $password): User
    {
        $hashedPassword = $this->passwordHasher->hashPassword(
            $user,
            $password
        );

        return $user->setPassword($hashedPassword);
    }
}

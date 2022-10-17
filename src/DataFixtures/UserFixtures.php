<?php

declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\User;
use Faker\Factory as FakerFactory;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class UserFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = FakerFactory::create();

        for ($i = 0; $i < 10; $i++) {
            $user = (new User())
                ->setEmail($faker->email())
                ->setRoles([])
                ->setPassword($faker->password(8, 18));

            $manager->persist($user);
        }
        $manager->flush();
    }
}

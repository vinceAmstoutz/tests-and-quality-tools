<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Unit\Trait;

use Symfony\Component\Validator\ConstraintViolation;

trait ErrorTrait
{
    public function assertHasError(object $object, int $expected = 0): void
    {
        $messages = [];
        self::bootKernel();

        $errors = static::getContainer()->get('validator')->validate($object);

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }

        $this->assertCount($expected, $errors, implode(',', $messages));
    }
}

<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Tests\PHPUnit\Unit\Trait;

use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

trait ErrorTrait
{
    public function assertHasError(object $object, int $expected = 0): void
    {
        $messages = [];
        self::bootKernel();

        /** @var Container */
        $container = static::getContainer();

        /** @var ValidatorInterface */
        $validator = $container->get('validator');
        $errors = $validator->validate($object);

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath().' => '.$error->getMessage();
        }

        $this->assertCount($expected, $errors, implode(',', $messages));
    }
}

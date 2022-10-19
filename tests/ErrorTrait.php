<?php

declare(strict_types=1);

namespace App\Tests;

trait ErrorTrait
{
    public function assertHasError(Object $object, int $expected = 0)
    {
        $messages = [];
        self::bootKernel();

        $errors = static::getContainer()->get('validator')->validate($object);

        /** @var ConstraintViolation $error */
        foreach ($errors as $error) {
            $messages[] = $error->getPropertyPath() . ' => ' . $error->getMessage();
        }

        $this->assertCount($expected, $errors, implode(',', $messages));
    }
}

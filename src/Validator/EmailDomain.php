<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Exception\ConstraintDefinitionException;

/**
 * @Annotation
 *
 * @Target({"PROPERTY", "METHOD", "ANNOTATION"})
 */
#[\Attribute(\Attribute::TARGET_PROPERTY | \Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class EmailDomain extends Constraint
{
    public string $message = 'The domain "{{ value }}" is not allowed.';
    public mixed $blocked = [];

    public function __construct(array $options = [])
    {
        parent::__construct($options);

        if (!\is_array($options['blocked'])) {
            throw new ConstraintDefinitionException('The blocked option must be an array of blocked domain');
        }
    }

    /**
     * @return array<string>
     */
    public function getRequiredOptions()
    {
        return ['blocked'];
    }
}

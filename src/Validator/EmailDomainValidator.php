<?php

declare(strict_types=1);

/*
 * (c) Vincent AMSTOUTZ <vincent.amstoutz.dev@gmail.com>
 *
 * Unlicensed
 */

namespace App\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class EmailDomainValidator extends ConstraintValidator
{
    public function validate(mixed $value, Constraint $constraint): void
    {
        if (null === $value || '' === $value) {
            return;
        }
        /** @var string $value */
        $domain = $this->getDomain($value);

        /** @var EmailDomain $constraint */
        if (\in_array($domain, (array) $constraint->blocked, true)) {
            $this->context->buildViolation((string) $constraint->message)
                ->setParameter('{{ value }}', $value)
                ->addViolation();
        }
    }

    private function getDomain(string $email): string
    {
        return mb_substr($email, mb_strpos($email, '@') + 1);
    }
}

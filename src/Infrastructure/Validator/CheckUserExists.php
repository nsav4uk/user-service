<?php

declare(strict_types=1);

namespace User\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;

#[\Attribute]
class CheckUserExists extends Constraint
{
    public string $userExists = 'User already exists.';

    public function getTargets(): string
    {
        return self::CLASS_CONSTRAINT;
    }
}

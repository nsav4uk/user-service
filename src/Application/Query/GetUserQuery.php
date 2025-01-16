<?php

declare(strict_types=1);

namespace User\Application\Query;

readonly class GetUserQuery
{
    public function __construct(
        private string $email
    ) {
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

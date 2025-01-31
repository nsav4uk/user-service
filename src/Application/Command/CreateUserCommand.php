<?php

declare(strict_types=1);

namespace User\Application\Command;

readonly class CreateUserCommand
{
    public function __construct(
        private ?string $email,
        private ?string $password,
    ) {}

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

<?php

declare(strict_types=1);

namespace User\Domain\Model\User;

class User
{
    public function __construct(
        private ?int $id,
        private string $email,
        private string $password,
        private array $roles = [],
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

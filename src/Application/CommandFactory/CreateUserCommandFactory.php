<?php

declare(strict_types=1);

namespace User\Application\CommandFactory;

use User\Application\Command\CreateUserCommand;

readonly class CreateUserCommandFactory
{
    public function create(array $data): CreateUserCommand
    {
        return new CreateUserCommand(
            $data['email'] ?? null,
            $data['password'] ?? null,
        );
    }
}

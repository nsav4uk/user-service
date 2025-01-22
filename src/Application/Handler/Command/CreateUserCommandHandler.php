<?php

declare(strict_types=1);

namespace User\Application\Handler\Command;

use User\Application\Command\CreateUserCommand;
use User\Application\Handler\CommandHandlerInterface;
use User\Application\Service\UserRepositoryInterface;
use User\Domain\Model\User\User;

readonly class CreateUserCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User(
            $this->repository->nextIdentity(),
            $command->getEmail(),
            $command->getPassword(),
        );

        $this->repository->save($user);
    }
}

<?php

declare(strict_types=1);

namespace User\Application\Command;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use User\Application\Service\UserServiceInterface;
use User\Domain\Entity\User;

#[AsMessageHandler]
readonly class CreateUserCommandHandler
{
    public function __construct(
        private UserServiceInterface $userService,
    ) {
    }

    public function __invoke(CreateUserCommand $command): void
    {
        $user = new User(
            id: null,
            email: $command->getEmail(),
            password: $command->getPassword(),
        );

        $this->userService->save($user);
    }
}

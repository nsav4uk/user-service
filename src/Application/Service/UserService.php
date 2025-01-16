<?php

declare(strict_types=1);

namespace User\Application\Service;

use User\Domain\Entity\User;

readonly class UserService implements UserServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ) {
    }

    public function save(User $user): void
    {
        $this->userRepository->save($user);
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->userRepository->findOneByEmail($email);
    }
}

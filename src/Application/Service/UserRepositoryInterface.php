<?php

namespace User\Application\Service;

use User\Domain\Model\User\User;

interface UserRepositoryInterface
{
    public function nextIdentity(): int;

    public function save(User $user): void;

    public function update(User $user): void;

    public function findOneByEmail(string $email): ?User;

    public function findOneById(int $id): ?User;
}
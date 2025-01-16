<?php

namespace User\Application\Service;

use User\Domain\Entity\User;

interface UserRepositoryInterface
{
    public function save(User $user): void;
    public function findOneByEmail(string $email): ?User;
}
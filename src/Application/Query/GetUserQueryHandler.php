<?php

declare(strict_types=1);

namespace User\Application\Query;

use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use User\Application\Service\UserServiceInterface;

#[AsMessageHandler]
readonly class GetUserQueryHandler
{
    public function __construct(
        private UserServiceInterface $userService
    ) {
    }

    public function __invoke(GetUserQuery $query)
    {
        return $this->userService->findOneByEmail($query->getEmail());
    }
}

<?php

declare(strict_types=1);

namespace User\Application\Handler\Query;

use User\Application\Handler\QueryHandlerInterface;
use User\Application\NormalizerFactory\UserNormalizerFactory;
use User\Application\Query\GetUserQuery;
use User\Application\Service\UserRepositoryInterface;

readonly class GetUserQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private UserRepositoryInterface $repository,
        private UserNormalizerFactory $factory,
    ) {
    }

    public function __invoke(GetUserQuery $query)
    {
        $user = $this->repository->findOneByEmail($query->getEmail());

        return $this->factory->create()->normalize($user);
    }
}

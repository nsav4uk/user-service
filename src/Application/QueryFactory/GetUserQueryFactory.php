<?php

declare(strict_types=1);

namespace User\Application\QueryFactory;

use User\Application\Query\GetUserQuery;

readonly class GetUserQueryFactory
{
    public function create(array $data): GetUserQuery
    {
        return new GetUserQuery(
            $data['email'] ?? null,
        );
    }
}

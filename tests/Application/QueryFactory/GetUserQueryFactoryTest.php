<?php

declare(strict_types=1);

namespace Application\QueryFactory;

use PHPUnit\Framework\TestCase;
use User\Application\QueryFactory\GetUserQueryFactory;

class GetUserQueryFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new GetUserQueryFactory();

        $command = $factory->create([
            'email' => 'test@test.com',
        ]);

        self::assertSame('test@test.com', $command->getEmail());
    }
}

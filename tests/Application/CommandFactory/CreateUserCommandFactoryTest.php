<?php

declare(strict_types=1);

namespace User\Tests\Application\CommandFactory;

use PHPUnit\Framework\TestCase;
use User\Application\CommandFactory\CreateUserCommandFactory;

class CreateUserCommandFactoryTest extends TestCase
{
    public function testCreate(): void
    {
        $factory = new CreateUserCommandFactory();

        $command = $factory->create([
            'email' => 'test@test.com',
            'password' => 'password',
        ]);

        self::assertSame('test@test.com', $command->getEmail());
        self::assertSame('password', $command->getPassword());
    }
}

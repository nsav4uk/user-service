<?php

declare(strict_types=1);

namespace User\Tests\Domain\Model\User;

use PHPUnit\Framework\TestCase;
use User\Domain\Model\User\User;

class UserTest extends TestCase
{
    public function testCreate(): void
    {
        $user = new User(1, 'test@test.com', 'password');

        self::assertSame(1, $user->getId());
        self::assertSame('test@test.com', $user->getEmail());
        self::assertSame('password', $user->getPassword());
        self::assertSame(['ROLE_USER'], $user->getRoles());
    }
}

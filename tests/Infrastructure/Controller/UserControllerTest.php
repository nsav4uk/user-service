<?php

declare(strict_types=1);

namespace User\Tests\Infrastructure\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use User\Domain\Model\User\User;

class UserControllerTest extends WebTestCase
{
    private const USER_EMAIL = 'test@test.com';
    private KernelBrowser $client;
    private EntityManagerInterface $entityManager;

    public function setUp(): void
    {
        $this->client = static::createClient();
        $this->entityManager = self::getContainer()->get('doctrine.orm.entity_manager');
    }

    public function testIndex(): void
    {
        $this->createUser();
        $this->client->jsonRequest('GET', '/api/user/' . self::USER_EMAIL);
        self::assertResponseIsSuccessful();
    }

    public function testIndexNotFound(): void
    {
        $this->client->jsonRequest('GET', '/api/user/test1@test.com');
        self::assertResponseStatusCodeSame(404);
    }

    public function testGetUserWithNotValidEmail(): void
    {
        $this->client->jsonRequest('GET', '/api/user/test1');
        self::assertResponseStatusCodeSame(400);
    }

    public function testCreateUserEmptyForm(): void
    {
        $this->client->jsonRequest('POST', '/api/user');
        self::assertResponseStatusCodeSame(400);
    }

    public function testCreate(): void
    {
        $this->client->jsonRequest('POST', '/api/user', [
            'email' => 'test1@test.com',
            'password' => 'password',
        ]);
        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(201);
    }

    public function testCreateWithDuplicate(): void
    {
        $this->client->jsonRequest('POST', '/api/user', [
            'email' => 'test1@test.com',
            'password' => 'password',
        ]);

        $this->client->jsonRequest('POST', '/api/user', [
            'email' => 'test1@test.com',
            'password' => 'password',
        ]);

        self::assertResponseStatusCodeSame(400);
    }

    private function createUser(): void
    {
        $user = new User(null, self::USER_EMAIL, 'password');

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}

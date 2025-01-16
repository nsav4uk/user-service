<?php

declare(strict_types=1);

namespace User\Tests\Infrastructure\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use User\Domain\Entity\User;

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
        $this->client->jsonRequest('GET', '/' . self::USER_EMAIL);
        self::assertResponseIsSuccessful();
    }

    public function testIndexNotFound(): void
    {
        $this->client->jsonRequest('GET', '/test1@test.com');
        self::assertResponseStatusCodeSame(404);
    }

    public function testCreate(): void
    {
        $this->client->jsonRequest('POST', '/', [
            'email' => 'test1@test.com',
            'password' => 'password',
        ]);
        self::assertResponseIsSuccessful();
        self::assertResponseStatusCodeSame(201);
    }

    private function createUser(): void
    {
        $user = new User(null, self::USER_EMAIL, 'password');

        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }
}

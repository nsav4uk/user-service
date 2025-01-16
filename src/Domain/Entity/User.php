<?php

declare(strict_types=1);

namespace User\Domain\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use User\Infrastructure\Repository\UserRepository;

#[ORM\Table(name: 'users')]
#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    public function __construct(
        #[ORM\Id]
        #[ORM\GeneratedValue]
        #[ORM\Column(type: Types::INTEGER)]
        private ?int $id,

        #[ORM\Column(type: Types::STRING, length: 180, unique: true)]
        private readonly ?string $email,

        #[ORM\Column(type: Types::STRING)]
        private readonly string $password,

        #[ORM\Column(type: Types::JSON)]
        private array $roles = [],
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}

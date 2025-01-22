<?php

declare(strict_types=1);

namespace User\Infrastructure\Persistence\Doctrine\Repository;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use User\Application\Service\UserRepositoryInterface;
use User\Domain\Model\User\User;

class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    public function nextIdentity(): int
    {
        return $this
            ->getEntityManager()
            ->getConnection()
            ->executeQuery('SELECT nextval(\'users_id_seq\')')
            ->fetchOne();
    }

    public function findOneByEmail(string $email): ?User
    {
        return $this->createQueryBuilder('u')
            ->where('u.email = :email')
            ->setParameter('email', $email)
            ->getQuery()
            ->getOneOrNullResult();
    }

    public function findOneById(int $id): ?User
    {
        return $this->find($id);
    }

    public function update(User $user): void
    {
        $this->getEntityManager()->flush();
    }

    public function save(User $user): void
    {
       $this->getEntityManager()->persist($user);
       $this->getEntityManager()->flush();
    }
}

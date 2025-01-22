<?php

declare(strict_types=1);

namespace User\Infrastructure\Validator;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use User\Application\Service\UserRepositoryInterface;

class CheckUserExistsValidator extends ConstraintValidator
{
    public function __construct(
        private readonly UserRepositoryInterface $repository,
    ) {}

    public function validate(mixed $value, Constraint $constraint): void
    {
        if (!$constraint instanceof CheckUserExists) {
            throw new UnexpectedTypeException($constraint, CheckUserExists::class);
        }

        $email = $value->getEmail();

        if (null === $email) {
            return;
        }

        $user = $this->repository->findOneByEmail($value->getEmail());

        if ($user) {
            $this->context
                ->buildViolation($constraint->userExists)
                ->atPath('error')
                ->addViolation();
        }
    }
}

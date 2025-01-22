<?php

declare(strict_types=1);

namespace User\Application\Normalizer;

use User\Domain\Model\User\User;

class UserNormalizer implements NormalizerInterface
{
    public function normalize($object): array
    {
        if (!$object instanceof User) {
            return [];
        }

        return [
            'id' => $object->getId(),
            'email' => $object->getEmail(),
            'password' => $object->getPassword(),
            'roles' => $object->getRoles(),
        ];
    }
}

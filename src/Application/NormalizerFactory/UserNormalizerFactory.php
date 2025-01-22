<?php

declare(strict_types=1);

namespace User\Application\NormalizerFactory;

use User\Application\Normalizer\NormalizerInterface;
use User\Application\Normalizer\UserNormalizer;

class UserNormalizerFactory implements NormalizerFactoryInterface
{
    public function create(): NormalizerInterface
    {
        return new UserNormalizer();
    }
}

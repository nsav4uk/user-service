<?php

namespace User\Application\NormalizerFactory;

use User\Application\Normalizer\NormalizerInterface;

interface NormalizerFactoryInterface
{
    public function create(): NormalizerInterface;
}
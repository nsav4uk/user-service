<?php

namespace User\Application\Normalizer;

interface NormalizerInterface
{
    public function normalize($object): array;
}
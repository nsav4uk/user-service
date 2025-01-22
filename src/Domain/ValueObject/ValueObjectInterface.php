<?php

namespace User\Domain\ValueObject;

interface ValueObjectInterface
{
    public function getValue();

    public function __toString(): string;
}
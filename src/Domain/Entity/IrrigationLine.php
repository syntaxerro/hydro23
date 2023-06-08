<?php

namespace App\Domain\Entity;

use App\Infrastructure\Entity\JsonDeserializableEntityTrait;
use App\Infrastructure\Entity\JsonSerializableEntityTrait;
use JsonSerializable;

class IrrigationLine implements JsonSerializable
{
    use JsonSerializableEntityTrait;
    use JsonDeserializableEntityTrait;
    public function __construct(
        private int $identifier,
        private string $name,
    ) {
    }

    public function getIdentifier(): int
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }
}
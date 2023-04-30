<?php

namespace App\Domain\Entity;

use App\Native\Entity\JsonDeserializableEntityTrait;
use App\Native\Entity\JsonSerializableEntityTrait;
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
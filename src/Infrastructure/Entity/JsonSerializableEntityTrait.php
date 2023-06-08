<?php

namespace App\Infrastructure\Entity;

trait JsonSerializableEntityTrait
{
    public function jsonSerialize(): mixed
    {
        return get_object_vars($this);
    }
}
<?php

namespace App\Native\Entity;

trait JsonDeserializableEntityTrait
{
    public static function fromArray(array $array): static
    {
        $constructorParams = array_values($array);
        return new static(...$constructorParams);
    }
}
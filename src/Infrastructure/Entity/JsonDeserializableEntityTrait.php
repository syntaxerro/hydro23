<?php

namespace App\Infrastructure\Entity;

trait JsonDeserializableEntityTrait
{
    public static function fromArray(array $array): static
    {
        $constructorValues = [];

        $ref = new \ReflectionClass(static::class);
        $constructorParams = $ref->getConstructor()->getParameters();
        foreach ($constructorParams as $constructorParam) {
            foreach ($array as $key => $value) {
                if ($key == $constructorParam->getName()) {
                    $constructorValues[] = $value;
                }
            }
        }
        return new static(...$constructorValues);
    }
}
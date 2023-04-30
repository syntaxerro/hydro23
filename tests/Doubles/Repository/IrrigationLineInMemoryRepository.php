<?php

namespace App\Tests\Doubles\Repository;

use App\Domain\Entity\IrrigationLine;
use App\Domain\Repository\IrrigationLineRepositoryInterface;

class IrrigationLineInMemoryRepository implements IrrigationLineRepositoryInterface
{
    /** @var IrrigationLine[] */
    private array $entities = [];

    public function save(IrrigationLine $irrigationLine): void
    {
        $this->entities[$irrigationLine->getIdentifier()] = $irrigationLine;
    }

    public function delete(IrrigationLine $irrigationLine): void
    {
        foreach ($this->entities as $index => $entity) {
            if ($entity->getIdentifier() === $irrigationLine->getIdentifier()) {
                unset($this->entities[$index]);
            }
        }

        $this->entities = array_values($this->entities);
    }

    public function get(int $identifier): IrrigationLine
    {
        foreach ($this->entities as $entity) {
            if ($entity->getIdentifier() === $identifier) {
                return $entity;
            }
        }

        throw new \LogicException('Not found entity IrrigationLine with #id ' . $identifier);
    }

    public function findAll(): array
    {
        return $this->entities;
    }
}
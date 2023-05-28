<?php

namespace App\Tests\Doubles\Repository;

use App\Domain\Entity\Schedule;
use App\Domain\Repository\ScheduleRepositoryInterface;

class ScheduleInMemoryRepository implements ScheduleRepositoryInterface
{
    /** @var Schedule[] */
    private array $entities = [];

    public function save(Schedule $schedule): void
    {
        $this->entities[$schedule->getId()] = $schedule;
    }

    public function delete(Schedule $schedule): void
    {
        foreach ($this->entities as $index => $entity) {
            if ($entity->getId() === $schedule->getId()) {
                unset($this->entities[$index]);
            }
        }

        $this->entities = array_values($this->entities);
    }

    public function get(string $id): Schedule
    {
        foreach ($this->entities as $entity) {
            if ($entity->getId() === $id) {
                return $entity;
            }
        }

        throw new \LogicException('Not found entity Schedule with #id ' . $id);
    }

    public function findAll(): array
    {
        return $this->entities;
    }

    public function findByIrrigationLine(int $irrigationLineIdentifier): array
    {
        $result = [];
        foreach ($this->findAll() as $item) {
            if ($item->getIrrigationLineIdentifier() == $irrigationLineIdentifier) {
                $result[] = $item;
            }
        }
        return $result;
    }
}
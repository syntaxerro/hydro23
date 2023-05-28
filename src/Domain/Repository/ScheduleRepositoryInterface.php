<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Schedule;

interface ScheduleRepositoryInterface
{
    public function save(Schedule $schedule): void;

    public function delete(Schedule $schedule): void;

    public function get(string $id): Schedule;

    /** @return Schedule[] */
    public function findAll(): array;

    /** @return Schedule[] */
    public function findByIrrigationLine(int $irrigationLineIdentifier): array;
}
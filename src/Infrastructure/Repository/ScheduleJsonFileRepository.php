<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Schedule;
use App\Domain\Repository\ScheduleRepositoryInterface;
use App\Native\Repository\JsonFileRepository;

class ScheduleJsonFileRepository implements ScheduleRepositoryInterface
{
    private readonly JsonFileRepository $nativeRepository;

    public function __construct()
    {
        $this->nativeRepository = new JsonFileRepository(Schedule::class, 'id');
    }

    public function save(Schedule $schedule): void
    {
        $this->nativeRepository->save($schedule);
    }

    public function delete(Schedule $schedule): void
    {
        $this->nativeRepository->delete($schedule);
    }

    public function get(string $id): Schedule
    {
        $schedule = $this->nativeRepository->find($id);
        if (!$schedule) {
            throw new \LogicException('Not found entity Schedule with #id ' . $schedule);
        }
        return $schedule;
    }

    public function findAll(): array
    {
        return $this->nativeRepository->all();
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
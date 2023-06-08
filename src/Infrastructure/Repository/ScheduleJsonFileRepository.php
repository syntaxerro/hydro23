<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Schedule;
use App\Domain\Repository\ScheduleRepositoryInterface;
use App\Infrastructure\Repository\GenericJsonFileRepository;

class ScheduleJsonFileRepository implements ScheduleRepositoryInterface
{
    private readonly GenericJsonFileRepository $nativeRepository;

    public function __construct()
    {
        $this->nativeRepository = new GenericJsonFileRepository(Schedule::class, 'id');
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
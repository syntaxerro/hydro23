<?php

namespace App\Tests\Unit\Repository;

use App\Domain\Entity\Schedule;
use App\Domain\Repository\ScheduleRepositoryInterface;
use App\Tests\Doubles\Repository\ScheduleInMemoryRepository;
use App\Tests\TestTemplate\ScheduleRepositoryTestTemplate;

class ScheduleInMemoryRepositoryTest extends ScheduleRepositoryTestTemplate
{
    private readonly ScheduleInMemoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->repository = self::getContainer()->get(ScheduleRepositoryInterface::class);
    }

    protected function repository(): ScheduleRepositoryInterface
    {
        return $this->repository;
    }

    protected function save(Schedule $schedule): void
    {
        $this->repository->save($schedule);
        parent::save($schedule);
    }
}
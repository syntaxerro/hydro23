<?php

namespace App\Tests\Integration\Infrastructure\Repository;

use App\Domain\Entity\Schedule;
use App\Domain\Repository\ScheduleRepositoryInterface;
use App\Infrastructure\Repository\ScheduleJsonFileRepository;
use App\Tests\TestTemplate\ScheduleRepositoryTestTemplate;

class ScheduleJsonFileRepositoryTest extends ScheduleRepositoryTestTemplate
{
    private readonly ScheduleRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->repository = self::getContainer()->get(ScheduleJsonFileRepository::class);
        foreach($this->repository()->findAll() as $item) {
            $this->repository()->delete($item);
        }
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
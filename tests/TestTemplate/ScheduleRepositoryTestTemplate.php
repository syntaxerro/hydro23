<?php

namespace App\Tests\TestTemplate;

use App\Domain\Entity\Schedule;
use App\Domain\Repository\ScheduleRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class ScheduleRepositoryTestTemplate extends KernelTestCase
{
    private array $persistedObjects = [];

    abstract protected function repository(): ScheduleRepositoryInterface;
    protected function save(Schedule $schedule): void
    {
        $this->persistedObjects[] = $schedule;
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        foreach ($this->persistedObjects as $object) {
            $this->repository()->delete($object);
        }
    }

    /** @test */
    public function add_and_get_by_identifier(): void
    {
        // given
        $givenIdentifier = uniqid(uniqid());

        // when
        $this->save(new Schedule(1, '18:00', 0, '5s', $givenIdentifier));

        // then
        $line = $this->repository()->get($givenIdentifier);
        $this->assertInstanceOf(Schedule::class, $line);
        $this->assertEquals($givenIdentifier, $line->getId());
    }

    /** @test */
    public function add_and_delete_by_identifier(): void
    {
        // given
        $givenSchedule = new Schedule(1, '18:00', 0, '5s');
        $this->save($givenSchedule);

        // when
        $this->repository()->delete($givenSchedule);

        // then
        $this->expectException(\LogicException::class);
        $this->repository()->get($givenSchedule->getId());
    }

    /** @test */
    public function find_all(): void
    {
        // given
        $givenSchedule = new Schedule(1, '18:00', 0, '5s');
        $this->save($givenSchedule);

        // when
        $result = $this->repository()->findAll();

        // then
        $this->assertCount(1, $result);
    }

    /** @test */
    public function find_by_irrigation_line(): void
    {
        // given
        $givenIrrigationLineId = 1;
        $this->save(new Schedule($givenIrrigationLineId, '18:00', -1, '5s'));
        $this->save(new Schedule($givenIrrigationLineId, '18:00', -1, '5s'));

        // when
        $result = $this->repository()->findByIrrigationLine($givenIrrigationLineId);

        // then
        $this->assertCount(2, $result);
    }
}
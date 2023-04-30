<?php

namespace App\Tests\Unit\Commands\IrrigationLine;

use App\Domain\Command\IrrigationLine\SetIrrigationLineCommand;
use App\Domain\Entity\IrrigationLine;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use App\Tests\Common\UnitTestCase;

class SetIrrigationLineCommandTest extends UnitTestCase
{
    private IrrigationLineRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->container->get(IrrigationLineRepositoryInterface::class);
    }

    /** @test */
    public function add_new_irrigation_line(): void
    {
        // given
        $givenName = 'truskawki';
        $givenIdentifier = 1;

        // when
        $this->dispatchMessage(new SetIrrigationLineCommand($givenName, $givenIdentifier));

        // then
        $line = $this->repository->get($givenIdentifier);
        $this->assertInstanceOf(IrrigationLine::class, $line);
    }

    /** @test */
    public function update_irrigation_line(): void
    {
        // given
        $givenName = 'truskawki';
        $givenIdentifier = 1;
        $this->dispatchMessage(new SetIrrigationLineCommand('other name', $givenIdentifier));

        // when
        $this->dispatchMessage(new SetIrrigationLineCommand($givenName, $givenIdentifier));

        // then
        $line = $this->repository->get($givenIdentifier);
        $this->assertInstanceOf(IrrigationLine::class, $line);
        $this->assertEquals($givenName, $line->getName());
    }
}
<?php

namespace App\Tests\Unit\Commands\IrrigationLine;

use App\Domain\Command\IrrigationLine\RemoveIrrigationLineCommand;
use App\Domain\Command\IrrigationLine\SetIrrigationLineCommand;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use App\Tests\Common\UnitTestCase;
use LogicException;

class RemoveIrrigationLineCommandTest extends UnitTestCase
{
    private IrrigationLineRepositoryInterface $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = $this->container->get(IrrigationLineRepositoryInterface::class);
    }

    /** @test */
    public function delete_irrigation_line(): void
    {
        // given
        $givenIdentifier = 1;
        $this->dispatchMessage(new SetIrrigationLineCommand('truskawki', $givenIdentifier));

        // when
        $this->dispatchMessage(new RemoveIrrigationLineCommand($givenIdentifier));

        // then
        $this->expectException(LogicException::class);
        $this->repository->get($givenIdentifier);
    }
}
<?php

namespace App\Tests\Unit\Commands;

use App\Domain\Command\TurnTheValveCommand;
use App\Domain\ValvesInterface;
use App\Tests\Common\UnitTestCase;

class TurnTheValveCommandTest extends UnitTestCase
{
    private ValvesInterface $valves;

    protected function setUp(): void
    {
        parent::setUp();
        $this->valves = $this->container->get(ValvesInterface::class);
    }

    /** @test */
    public function open_first_valve(): void
    {
        // given
        $givenIdentifier = 1;
        $this->giveIrrigationLines([$givenIdentifier]);

        // when
        $this->dispatchMessage(new TurnTheValveCommand($givenIdentifier, true));

        // then
        $currentValveState = $this->valves->readValveState($givenIdentifier);
        $this->assertTrue($currentValveState);
    }

    /** @test */
    public function close_valve(): void
    {
        // given
        $givenIdentifier = 1;
        $this->giveIrrigationLines([$givenIdentifier]);
        $command = new TurnTheValveCommand($givenIdentifier, true);
        $this->messageBus->dispatch($command);

        // when
        $command = new TurnTheValveCommand($givenIdentifier, false);
        $this->messageBus->dispatch($command);

        // then
        $currentValveState = $this->valves->readValveState($givenIdentifier);
        $this->assertFalse($currentValveState);
    }
}
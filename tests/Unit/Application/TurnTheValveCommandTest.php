<?php

namespace App\Tests\Unit\Application;

use App\Domain\Command\TurnTheValveCommand;
use App\Domain\Configuration\DriverConfig;
use App\Domain\ValvesInterface;
use App\Tests\Common\UnitTestCase;

class TurnTheValveCommandTest extends UnitTestCase
{
    private ValvesInterface $valves;
    private DriverConfig $config;

    protected function setUp(): void
    {
        parent::setUp();
        $this->valves = $this->container->get(ValvesInterface::class);
        $this->config = $this->container->get(DriverConfig::class);
    }

    /** @test */
    public function open_first_valve(): void
    {
        // given
        $givenValveIdentifier = $this->config->getValveIdentifiers()[0];

        // when
        $this->dispatchMessage(new TurnTheValveCommand($givenValveIdentifier, true));

        // then
        $currentValveState = $this->valves->readValveState($givenValveIdentifier);
        $this->assertTrue($currentValveState);
    }

    /** @test */
    public function close_valve(): void
    {
        // given
        $givenValveIdentifier = $this->config->getValveIdentifiers()[0];
        $command = new TurnTheValveCommand($givenValveIdentifier, true);
        $this->messageBus->dispatch($command);

        // when
        $command = new TurnTheValveCommand($givenValveIdentifier, false);
        $this->messageBus->dispatch($command);

        // then
        $currentValveState = $this->valves->readValveState($givenValveIdentifier);
        $this->assertFalse($currentValveState);
    }
}
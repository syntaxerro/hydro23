<?php

namespace App\Tests\Unit\Application;

use App\Domain\Command\EnablePumpCommand;
use App\Domain\Command\TurnTheValveCommand;
use App\Domain\PumpInterface;
use App\Domain\ValvesInterface;
use App\Tests\Common\UnitTestCase;

class EnablePumpCommandTest extends UnitTestCase
{
    private readonly PumpInterface $pump;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pump = $this->container->get(PumpInterface::class);
    }

    /** @test */
    public function enable_pump_when_at_least_one_valve_is_open(): void
    {
        // given
        $this->dispatchMessage(new TurnTheValveCommand(1, true));

        // when
        $this->dispatchMessage(new EnablePumpCommand());

        // then
        $this->assertTrue($this->pump->checkPumpState());
    }

    /** @test */
    public function dont_enable_pump_when_all_valves_are_closed(): void
    {
        // given
        // all valves are off by default

        // when
        $this->dispatchMessage(new EnablePumpCommand());

        // then
        $this->assertFalse($this->pump->checkPumpState());
    }
}
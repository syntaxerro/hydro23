<?php

namespace App\Tests\Unit\Commands;

use App\Domain\Command\Pump\EnablePumpCommand;
use App\Domain\Command\PushEmergencyButtonCommand;
use App\Domain\Command\TurnTheValveCommand;
use App\Domain\Event\PumpDisabledEvent;
use App\Domain\Event\ValveStateChangedEvent;
use App\Tests\Common\UnitTestCase;

class PushEmergencyButtonCommandTest extends UnitTestCase
{
    /** @test */
    public function stop_pumping_and_close_all_valves_on_emergency_button_push(): void
    {
        // given
        $this->openAllValves();
        $this->dispatchMessage(new EnablePumpCommand());

        // when
        $this->dispatchMessage(new PushEmergencyButtonCommand());

        // then
        $this->transport('sync')->acknowledged()->assertContains(PumpDisabledEvent::class);
        $this->transport('sync')->acknowledged()->assertContains(ValveStateChangedEvent::class);
    }

    private function openAllValves(): void
    {
        $givenIdentifiers = [1,2,3,4];
        $this->giveIrrigationLines($givenIdentifiers);
        foreach ($givenIdentifiers as $identifier) {
            $this->dispatchMessage(new TurnTheValveCommand($identifier, true));
        }
    }
}
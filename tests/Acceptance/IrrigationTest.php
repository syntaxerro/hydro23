<?php

namespace App\Tests\Acceptance;

use App\Infrastructure\Websocket\Dto\WebsocketIncomingMessage;
use App\Tests\Common\AcceptanceTestCase;
use App\Tests\Fixtures\CommandsMother;
use App\Tests\Fixtures\ValveStateMother;

class IrrigationTest extends AcceptanceTestCase
{
    /** @test */
    public function close_two_valves_while_pumping(): void
    {
        // given
        $allValves = [1,2,3,4];
        $this->giveIrrigationLines($allValves);
        $this->turnTheValves($allValves, ValveStateMother::on);
        $this->sendToWebsocket(
            new WebsocketIncomingMessage(CommandsMother::EnablePump)
        );

        // when
        $this->turnTheValves([1, 2], ValveStateMother::off);

        // then
        $this->assertIsPumping();
        $this->assertValveClose(1);
        $this->assertValveClose(2);
        $this->assertValveOpen(3);
        $this->assertValveOpen(4);
    }

    /** @test */
    public function turn_off_the_pump_when_close_all_valves_while_pumping(): void
    {
        // given
        $allValves = [1,2,3,4];
        $this->giveIrrigationLines($allValves);
        $this->turnTheValves($allValves, ValveStateMother::on);
        $this->sendToWebsocket(
            new WebsocketIncomingMessage(CommandsMother::EnablePump)
        );

        // when
        $this->turnTheValves([1, 2, 3, 4], ValveStateMother::off);

        // then
        $this->assertPumpingStopped();
    }

    /** @test */
    public function dont_enable_pump_when_all_valves_are_closed(): void
    {
        // given
        $allValves = [1,2,3,4];
        $this->giveIrrigationLines($allValves);
        $this->turnTheValves($allValves, ValveStateMother::off);

        // when
        $this->sendToWebsocket(
            new WebsocketIncomingMessage(CommandsMother::EnablePump)
        );

        // then
        $this->assertPumpingStopped();
    }

    private function turnTheValves(array $valvesIdentifiers, bool $valveOpen): void
    {
        foreach ($valvesIdentifiers as $givenValveIdentifier) {
            $this->sendToWebsocket(
                new WebsocketIncomingMessage(CommandsMother::TurnTheValve, [
                    'identifier' => $givenValveIdentifier,
                    'state' => $valveOpen
                ])
            );
        }
    }
}
<?php

namespace App\Tests\Common;

use App\Infrastructure\Websocket\Dto\WebsocketIncomingMessage;
use App\Infrastructure\Hardware\ProcessRunner;
use App\Tests\Fixtures\CommandsMother;
use App\Tests\Fixtures\EventsMother;
use App\Tests\Fixtures\ValveStateMother;
use PHPUnit\Framework\TestCase;
use WebSocket\Client;
use WebSocket\TimeoutException;

abstract class AcceptanceTestCase extends TestCase
{
    protected Client $websocketClient;
    private array $receivedMessageViaWebsocket = [];

    protected function setUp(): void
    {
        parent::setUp();
        $this->websocketClient = new Client('ws://localhost:9191');
        $this->receivedMessageViaWebsocket = [];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->sendToWebsocket(
            new WebsocketIncomingMessage(CommandsMother::PushEmergencyButton)
        );
    }

    protected function sendToWebsocket(WebsocketIncomingMessage $message): void
    {
        $json = json_encode($message);
        $this->websocketClient->text($json);
        $this->readFromWebsocket();
    }

    protected function assertIsPumping(): void
    {
        $lastPumpEvent = null;
        foreach ($this->receivedMessageViaWebsocket as $event) {
            if ($event['eventName'] == EventsMother::PumpEnabled || $event['eventName'] == EventsMother::PumpDisabled) {
                $lastPumpEvent = $event['eventName'];
            }
        }
        $this->assertEquals(EventsMother::PumpEnabled, $lastPumpEvent);
    }

    protected function assertPumpingStopped(): void
    {
        $lastPumpEvent = null;
        foreach ($this->receivedMessageViaWebsocket as $event) {
            if ($event['eventName'] == EventsMother::PumpEnabled || $event['eventName'] == EventsMother::PumpDisabled) {
                $lastPumpEvent = $event['eventName'];
            }
        }
        if ($lastPumpEvent === null) {
            $this->assertTrue(true);
            return;
        }
        $this->assertEquals(EventsMother::PumpDisabled, $lastPumpEvent);
    }

    protected function assertValveOpen(int $valveIdentifier): void
    {
        $lastValveEvent = null;
        foreach ($this->receivedMessageViaWebsocket as $event) {
            if ($event['eventName'] == EventsMother::ValveStateChanged && $event['event']['identifier'] == $valveIdentifier) {
                $lastValveEvent = $event['event'];
            }
        }

        $this->assertEquals([
            'identifier' => $valveIdentifier,
            'state' => ValveStateMother::on
        ], $lastValveEvent);
    }

    protected function assertValveClose(int $valveIdentifier): void
    {
        $lastValveEvent = null;
        foreach ($this->receivedMessageViaWebsocket as $event) {
            if ($event['eventName'] == EventsMother::ValveStateChanged && $event['event']['identifier'] == $valveIdentifier) {
                $lastValveEvent = $event['event'];
            }
        }

        if ($lastValveEvent === null) {
            $this->assertTrue(true);
            return;
        }
        $this->assertEquals([
            'identifier' => $valveIdentifier,
            'state' => ValveStateMother::off
        ], $lastValveEvent);
    }

    protected function readFromWebsocket(): void
    {
        try {
            $eventJson = $this->websocketClient->receive();
            $this->receivedMessageViaWebsocket[] = json_decode($eventJson, true);
        } catch(TimeoutException $exception) {
            // nothing
        }
    }
}
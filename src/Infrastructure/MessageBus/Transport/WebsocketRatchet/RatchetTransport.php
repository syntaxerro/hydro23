<?php

namespace App\Infrastructure\MessageBus\Transport\WebsocketRatchet;

use App\Domain\Messages\WebsocketEventInterface;
use App\Infrastructure\Websocket\ConnectedClients;
use App\Infrastructure\Websocket\Dto\WebsocketOutgoingMessage;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;
use Symfony\Component\Messenger\Transport\TransportInterface;

class RatchetTransport implements TransportInterface
{
    public function __construct(
        private readonly ConnectedClients $clients
    ) {
    }

    public function get(): iterable
    {
        return [];
    }

    public function ack(Envelope $envelope): void
    {
        // not using
    }

    public function reject(Envelope $envelope): void
    {
        // not using
    }

    public function send(Envelope $envelope): Envelope
    {
        $sentStamp = $envelope->last(SentStamp::class);
        $alias = null === $sentStamp ? 'sync' : ($sentStamp->getSenderAlias() ?: $sentStamp->getSenderClass());

        $envelope = $envelope->with(new ReceivedStamp($alias));
        $message = $envelope->getMessage();
        if ($message instanceof WebsocketEventInterface) {
            $this->clients->broadcastMessage(new WebsocketOutgoingMessage($message));
        }

        return $envelope;
    }
}
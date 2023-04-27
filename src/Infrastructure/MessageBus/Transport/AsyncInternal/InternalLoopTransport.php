<?php

namespace App\Infrastructure\MessageBus\Transport\AsyncInternal;

use React\EventLoop\LoopInterface;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\ReceivedStamp;
use Symfony\Component\Messenger\Stamp\SentStamp;
use Symfony\Component\Messenger\Transport\TransportInterface;

class InternalLoopTransport implements TransportInterface
{
    public function __construct(
        private readonly LoopInterface $loop,
        private readonly MessageBusInterface $messageBus
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
        $this->loop->addTimer(0, function() use($envelope) {
            $this->messageBus->dispatch($envelope);
        });
        return $envelope;
    }
}
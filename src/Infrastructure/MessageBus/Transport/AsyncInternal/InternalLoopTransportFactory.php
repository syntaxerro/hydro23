<?php

namespace App\Infrastructure\MessageBus\Transport\AsyncInternal;

use React\EventLoop\LoopInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class InternalLoopTransportFactory implements TransportFactoryInterface
{
    public function __construct(
        private readonly LoopInterface $loop,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return new InternalLoopTransport($this->loop, $this->messageBus);
    }

    public function supports(string $dsn, array $options): bool
    {
        return str_starts_with($dsn, 'loop://');
    }
}
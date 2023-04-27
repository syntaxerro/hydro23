<?php

namespace App\Infrastructure\MessageBus\Transport\WebsocketRatchet;

use App\Infrastructure\Websocket\ConnectedClients;
use Symfony\Component\Messenger\Transport\Serialization\SerializerInterface;
use Symfony\Component\Messenger\Transport\TransportFactoryInterface;
use Symfony\Component\Messenger\Transport\TransportInterface;

class RatchetTransportFactory implements TransportFactoryInterface
{
    public function __construct(private readonly ConnectedClients $clients)
    {
    }

    public function createTransport(string $dsn, array $options, SerializerInterface $serializer): TransportInterface
    {
        return new RatchetTransport($this->clients);
    }

    public function supports(string $dsn, array $options): bool
    {
        return str_starts_with($dsn, 'ratchet://');
    }
}
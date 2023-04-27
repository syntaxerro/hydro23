<?php

namespace App\Infrastructure\Websocket;

use App\Infrastructure\Websocket\Dto\WebsocketIncomingMessage;
use App\Infrastructure\MessageBus\CommandRunner;
use Psr\Log\LoggerInterface;
use Ratchet\ConnectionInterface;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\WebSocket\MessageComponentInterface;

class RatchetServer implements MessageComponentInterface
{
    public function __construct(
        InitializationRunner                    $initializationRunner,
        private readonly ConnectedClients       $clients,
        private readonly LoggerInterface        $logger,
        private readonly CommandRunner $commandRunner
    ) {
        $initializationRunner->registerInitializer();
    }

    public function onOpen(ConnectionInterface $conn): void
    {
        $this->clients->add($conn);
    }

    public function onClose(ConnectionInterface $conn): void
    {
        $this->clients->remove($conn);
    }

    public function onError(ConnectionInterface $conn, \Exception $e): void
    {
        $this->logger->critical($e->getMessage());
    }

    public function onMessage(ConnectionInterface $conn, MessageInterface $msg): void
    {
        $request = json_decode($msg->getPayload(), true);
        $websocketIncomingMessage = new WebsocketIncomingMessage($request['command'], $request['arguments']);

        $this->commandRunner->runCommand(
            $websocketIncomingMessage->command,
            $websocketIncomingMessage->arguments
        );
    }
}
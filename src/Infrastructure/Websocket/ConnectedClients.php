<?php

namespace App\Infrastructure\Websocket;

use App\Infrastructure\Websocket\Dto\WebsocketOutgoingMessage;
use Ratchet\ConnectionInterface;

class ConnectedClients
{
    /** @var ConnectionInterface[] */
    private array $clients = [];

    public function add(ConnectionInterface $connection): void
    {
        $this->clients[] = $connection;
    }

    public function remove(ConnectionInterface $connection): void
    {
        foreach ($this->clients as $i => $client) {
            if($client->resourceId == $connection->resourceId) {
                unset($this->clients[$i]);
            }
        }

        $this->clients = array_values($this->clients);
    }

    public function all(): array
    {
        return $this->clients;
    }

    public function broadcastMessage(WebsocketOutgoingMessage $websocketOutgoingMessage): void
    {
        foreach ($this->clients as $client) {
            $client->send(json_encode($websocketOutgoingMessage));
        }
    }
}
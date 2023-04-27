<?php

namespace App\UI\Command;

use App\Kernel;
use App\UI\CommandOutput;
use Ratchet\Server\IoServer;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:server:start')]
class StartWebsocketServerCommand extends Command
{
    public function __construct(private readonly Kernel $kernel)
    {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        /** @see \App\Infrastructure\Websocket\RatchetServer */
        CommandOutput::$output = $output;
        $output->writeln('Starting websocket server...');
        $this->kernel->getContainer()->get(IoServer::class)->run();
        return Command::SUCCESS;
    }
}
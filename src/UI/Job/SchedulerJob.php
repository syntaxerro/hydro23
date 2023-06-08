<?php

namespace App\UI\Job;

use App\Domain\Command\RunSchedulerCommand;
use Symfony\Component\Messenger\MessageBusInterface;

class SchedulerJob
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function getInterval(): int
    {
        return 30; // seconds;
    }

    public function run(): void
    {
        //$this->messageBus->dispatch(new RunSchedulerCommand());
    }
}
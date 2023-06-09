<?php

namespace App\UI\Job;

use App\Domain\Command\Schedule\RunSchedulerCommand;
use Symfony\Component\Messenger\MessageBusInterface;

class SchedulerJob
{
    public function __construct(
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function getInterval(): int
    {
        return 60; // seconds;
    }

    public function run(): void
    {
        $this->messageBus->dispatch(new RunSchedulerCommand());
    }
}
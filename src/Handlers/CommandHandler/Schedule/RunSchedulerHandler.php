<?php

namespace App\Handlers\CommandHandler\Schedule;

use App\Domain\Command\Schedule\PerformScheduleCommand;
use App\Domain\Command\Schedule\RunSchedulerCommand;
use App\Domain\Entity\Schedule;
use App\Domain\Repository\ScheduleRepositoryInterface;
use App\Domain\Service\Scheduler\DayOfWeekHandler;
use App\Domain\Service\Scheduler\IrrigationLineHandler;
use App\Domain\Service\Scheduler\StartAtHandler;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class RunSchedulerHandler
{
    public function __construct(
        private readonly ScheduleRepositoryInterface $scheduleRepository,
        private readonly DayOfWeekHandler $dayOfWeekHandler,
        private readonly StartAtHandler $startAtHandler,
        private readonly IrrigationLineHandler $irrigationLineHandler,
        private readonly MessageBusInterface $messageBus
    ) {
    }

    public function __invoke(RunSchedulerCommand $command): void
    {
        $this->configureChain();

        foreach ($this->scheduleRepository->findAll() as $schedule) {
            if (!$this->scheduleShouldBePerformed($schedule)) {
                continue;
            }

            $performCommand = new PerformScheduleCommand($schedule->getId());
            $this->messageBus->dispatch($performCommand);
        }
    }

    private function configureChain(): void
    {
        $this->dayOfWeekHandler->setNext($this->startAtHandler);
        $this->startAtHandler->setNext($this->irrigationLineHandler);
    }

    private function scheduleShouldBePerformed(Schedule $schedule): bool
    {
        $handled = $this->dayOfWeekHandler->handle($schedule);
        return $handled !== null;
    }
}
<?php

namespace App\Handlers\CommandHandler\Schedule;

use App\Domain\Command\Schedule\PerformScheduleCommand;
use App\Domain\Command\Pump\EnablePumpCommand;
use App\Domain\Command\TurnTheValveCommand;
use App\Domain\PumpInterface;
use App\Domain\Repository\ScheduleRepositoryInterface;
use App\Domain\Service\Scheduler\IrrigationTimeInterpreter;
use React\EventLoop\LoopInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Symfony\Component\Messenger\MessageBusInterface;

#[AsMessageHandler]
class PerformScheduleHandler
{
    public function __construct(
        private readonly MessageBusInterface $messageBus,
        private readonly PumpInterface $pump,
        private readonly LoopInterface $loop,
        private readonly ScheduleRepositoryInterface $scheduleRepository
    ) {
    }

    public function __invoke(PerformScheduleCommand $command): void
    {
        $schedule = $this->scheduleRepository->get($command->scheduleId);
        $turnTheValve = new TurnTheValveCommand($schedule->getIrrigationLineIdentifier(), true);
        $this->messageBus->dispatch($turnTheValve);

        if (!$this->pump->checkPumpState()) {
            $enablePumpCommand = new EnablePumpCommand();
            $this->messageBus->dispatch($enablePumpCommand);
        }

        $irrigationTime = IrrigationTimeInterpreter::interpret($schedule->getIrrigationTime());
        $this->loop->addTimer($irrigationTime, function() use($schedule) {
            $turnTheValve = new TurnTheValveCommand($schedule->getIrrigationLineIdentifier(), false);
            $this->messageBus->dispatch($turnTheValve);
        });
    }
}
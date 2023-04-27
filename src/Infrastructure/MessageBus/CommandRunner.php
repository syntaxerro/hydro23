<?php

namespace App\Infrastructure\MessageBus;

use App\Domain\Messages\CommandInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CommandRunner
{
    private const COMMAND_FQCN_PATTERN = 'App\Domain\Command\%s';
    public function __construct(private readonly MessageBusInterface $messageBus)
    {
    }

    public function runCommand(string $commandName, array $arguments): CommandInterface
    {
        $commandFqcn = sprintf(self::COMMAND_FQCN_PATTERN, $commandName);
        $commandParams = [];

        $ref = new \ReflectionClass($commandFqcn);
        if ($ref->getConstructor()) {
            foreach ($ref->getConstructor()->getParameters() as $constructParam) {
                if (!isset($arguments[$constructParam->getName()])) {
                    throw new \InvalidArgumentException(
                        sprintf(
                            'Missing argument %s for command %s',
                            $constructParam->getName(),
                            $commandName
                        )
                    );
                }

                $commandParams[] = $this->convertParamValueForType(
                    $constructParam->getType()->getName(),
                    $arguments[$constructParam->getName()]
                );
            }
        }

        $instance = new $commandFqcn(...$commandParams);
        $this->messageBus->dispatch($instance);
        return $instance;
    }

    private function convertParamValueForType(string $paramType, mixed $value): mixed
    {
        return match ($paramType) {
            \DateTimeInterface::class => $value->format('Y-m-d H:i:s'),
            'string' => (string)$value,
            'int' => (int)$value,
            'float' => (float)$value,
            default => $value,
        };
    }
}
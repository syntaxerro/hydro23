<?php

namespace App\Tests\Common;

use App\Domain\Messages\CommandInterface;
use App\Domain\Messages\EventInterface;
use App\Domain\Messages\QueryInterface;
use App\Domain\Command\TurnTheValveCommand;
use App\Domain\Service\Initializer;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Zenstruck\Messenger\Test\InteractsWithMessenger;

abstract class UnitTestCase extends KernelTestCase
{
    use InteractsWithMessenger;

    protected ContainerInterface $container;
    protected MessageBusInterface $messageBus;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->container = self::getContainer();
        $this->messageBus = $this->container->get(MessageBusInterface::class);
        $this->container->get(Initializer::class)->initValves();
        $this->container->get(Initializer::class)->initPump();
    }

    protected function dispatchMessage(CommandInterface|EventInterface|QueryInterface $message): void
    {
        $this->messageBus->dispatch($message);
        $this->transport('async')->process();
        $this->transport('sync')->process();
    }
}
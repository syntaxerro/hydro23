<?php

namespace App\Tests\Unit\Commands\Pump;

use App\Domain\Command\Pump\DisablePumpCommand;
use App\Domain\Command\Pump\EnablePumpCommand;
use App\Domain\PumpInterface;
use App\Tests\Common\UnitTestCase;

class DisablePumpCommandTest extends UnitTestCase
{
    private readonly PumpInterface $pump;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pump = $this->container->get(PumpInterface::class);
    }

    /** @test */
    public function disable_pump(): void
    {
        // given
        $this->dispatchMessage(new EnablePumpCommand());

        // when
        $this->dispatchMessage(new DisablePumpCommand());

        // then
        $this->assertFalse($this->pump->checkPumpState());
    }
}
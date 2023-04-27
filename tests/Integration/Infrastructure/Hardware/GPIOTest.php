<?php

namespace App\Tests\Integration\Infrastructure\Hardware;

use App\Infrastructure\Hardware\GPIO;
use App\Tests\Common\IntegrationTestCase;

class GPIOTest extends IntegrationTestCase
{
    private readonly GPIO $gpio;

    protected function setUp(): void
    {
        parent::setUp();
        $this->gpio = $this->container->get(GPIO::class);
    }

    /** @test */
    public function mark_channel_as_out(): void
    {
        // given
        $givenChannel = 1;

        // when
        $this->gpio->markChannelAsOut($givenChannel);

        // then
        $this->assertGpioDirection('out', $givenChannel);
    }

    /** @test */
    public function write_inverted_channel_value(): void
    {
        // given
        $givenChannel = 1;
        $this->gpio->enableGpioChannel($givenChannel);

        // when
        $this->gpio->writeChannelValue($givenChannel, true);

        // then
        $this->assertGpioValue(0, $givenChannel);
    }

    /** @test */
    public function read_channel_value(): void
    {
        // given
        $givenChannel = 1;
        $this->gpio->enableGpioChannel($givenChannel);
        $this->gpio->writeChannelValue($givenChannel, true);

        // when
        $value = $this->gpio->readChannelValue($givenChannel);

        // then
        $this->assertTrue($value);
    }

    private function assertGpioDirection(string $expectedDirection, int $gpioChannel): void
    {
        $content = file_get_contents(__DIR__ . '/../../../Doubles/gpio/gpio' . $gpioChannel . '/direction');
        $this->assertStringContainsString($expectedDirection, $content);
    }

    private function assertGpioValue(int $expectedState, int $gpioChannel): void
    {
        $content = file_get_contents(__DIR__ . '/../../../Doubles/gpio/gpio' . $gpioChannel . '/value');
        $this->assertEquals($expectedState, $content);
    }
}
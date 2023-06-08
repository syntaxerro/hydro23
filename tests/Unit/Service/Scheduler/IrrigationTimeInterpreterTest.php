<?php

namespace App\Tests\Unit\Service\Scheduler;

use App\Domain\Service\Scheduler\IrrigationTimeInterpreter;
use App\Tests\Common\UnitTestCase;

class IrrigationTimeInterpreterTest extends UnitTestCase
{
    /**
     * @test
     * @dataProvider cases
     */
    public function interpret_as_seconds($givenIrrigationTime, $expectedSeconds): void
    {
        // when
        $seconds = IrrigationTimeInterpreter::interpret($givenIrrigationTime);

        // then
        $this->assertEquals($expectedSeconds, $seconds);
    }

    private function cases(): array
    {
        return [
            '15s' => ['15s', 15],
            '1m' => ['1m', 60],
            '1m 25s' => ['1m 25s', 85],
            '2m' => ['2m', 120],
            '2m 40s' => ['2m 40s', 160],
        ];
    }
}
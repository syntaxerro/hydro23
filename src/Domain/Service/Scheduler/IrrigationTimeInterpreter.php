<?php

namespace App\Domain\Service\Scheduler;

class IrrigationTimeInterpreter
{
    public static function interpret(string $irrigationTime): int
    {
        $totalNumberOfSeconds = 0;

        $parts = explode(' ', $irrigationTime);
        foreach ($parts as $part) {
            preg_match('/(\d+)(m|s)/', $part, $matches);
            $numericValue = $matches[1];
            $unitValue = $matches[2];
            if ($unitValue == 's') {
                $totalNumberOfSeconds += $numericValue;
            }
            if ($unitValue == 'm') {
                $totalNumberOfSeconds += $numericValue*60;
            }
        }

        return $totalNumberOfSeconds;
    }
}
<?php

namespace App\Infrastructure\Config;

class GpioConfig
{
    public function __construct(public string $path)
    {
    }
}
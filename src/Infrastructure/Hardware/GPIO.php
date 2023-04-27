<?php

namespace App\Infrastructure\Hardware;

use App\Infrastructure\Config\GpioConfig;

class GPIO
{
    public function __construct(
        private readonly ProcessRunner $runner,
        private readonly GpioConfig $config
    ) {
    }

    public function writeChannelValue(int $channel, bool $value): void
    {
        $this->runner->runProcessSync('echo ' . ($value ? '0' : '1') . ' > ' . $this->config->path . 'gpio' . $channel . '/value');
    }

    public function readChannelValue(int $channel): bool
    {
        $result = file_get_contents($this->config->path . 'gpio' . $channel . '/value');
        return trim($result) == 0;
    }

    public function markChannelAsOut(int $channel): void
    {
        $this->runner->runProcessSync('echo out > ' . $this->config->path . 'gpio' . $channel . '/direction');
    }

    public function enableGpioChannel(int $channel): void
    {
        $this->runner->runProcessSync('echo ' . $channel . ' > ' . $this->config->path . 'export');
    }
}
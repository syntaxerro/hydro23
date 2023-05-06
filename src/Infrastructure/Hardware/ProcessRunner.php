<?php

namespace App\Infrastructure\Hardware;

use React\ChildProcess\Process;

class ProcessRunner
{
    public function runProcessSync(string $cmd): string
    {
        $proc = $this->runProcessAsync($cmd);
        $proc->on('data', function($chunk) use(&$output) {
            $output .= $chunk;
        });
        $output = '';
        while ($proc->isRunning()) {
            // wait
        }

        if ($proc->getExitCode() > 0) {
            throw new \RuntimeException($cmd.PHP_EOL.$output);
        }
        return $output;
    }

    public function runProcessAsync(string $cmd): Process
    {
        $proc = new Process($cmd);
        $proc->start();
        return $proc;
    }
}
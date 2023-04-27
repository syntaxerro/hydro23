<?php

namespace App\UI;

use Symfony\Component\Console\Output\OutputInterface;

class CommandOutput
{
    public static OutputInterface $output;

    public static function writeln(string $line): void
    {
        self::$output->writeln($line);
    }
}
<?php

namespace App\Domain\Query;

use App\Domain\Messages\QueryInterface;

class ValveStateQuery implements QueryInterface
{
    public function __construct(public int $valveIdentifier)
    {
    }
}
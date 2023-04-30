<?php

namespace App\Domain\Repository;

use App\Domain\Entity\IrrigationLine;

interface IrrigationLineRepositoryInterface
{
    public function save(IrrigationLine $irrigationLine): void;

    public function delete(IrrigationLine $irrigationLine): void;

    public function get(int $identifier): IrrigationLine;

    /** @return IrrigationLine[] */
    public function findAll(): array;
}
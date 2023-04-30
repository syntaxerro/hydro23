<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\IrrigationLine;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use App\Native\Repository\JsonFileRepository;

class IrrigationLineJsonFileRepository implements IrrigationLineRepositoryInterface
{
    private readonly JsonFileRepository $nativeRepository;

    public function __construct()
    {
        $this->nativeRepository = new JsonFileRepository(IrrigationLine::class, 'identifier');
    }

    public function save(IrrigationLine $irrigationLine): void
    {
        $this->nativeRepository->save($irrigationLine);
    }

    public function delete(IrrigationLine $irrigationLine): void
    {
        $this->nativeRepository->delete($irrigationLine);
    }

    public function get(int $identifier): IrrigationLine
    {
        $line = $this->nativeRepository->find($identifier);
        if (!$line) {
            throw new \LogicException('Not found entity IrrigationLine with #id ' . $identifier);
        }
        return $line;
    }

    public function findAll(): array
    {
        return $this->nativeRepository->all();
    }
}
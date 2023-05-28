<?php

namespace App\Tests\Unit\Repository;

use App\Domain\Repository\IrrigationLineRepositoryInterface;
use App\Tests\Doubles\Repository\IrrigationLineInMemoryRepository;
use App\Tests\TestTemplate\IrrigationLineRepositoryTestTemplate;

class IrrigationLineInMemoryRepositoryTest extends IrrigationLineRepositoryTestTemplate
{
    private IrrigationLineInMemoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->repository = self::getContainer()->get(IrrigationLineRepositoryInterface::class);
    }

    protected function repository(): IrrigationLineRepositoryInterface
    {
        return $this->repository;
    }
}
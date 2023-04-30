<?php

namespace App\Tests\Integration\Infrastructure\Repository;

use App\Domain\Repository\IrrigationLineRepositoryInterface;
use App\Infrastructure\Repository\IrrigationLineJsonFileRepository;
use App\Tests\TestTemplate\IrrigationLineRepositoryTestTemplate;

class IrrigationLineJsonFileRepositoryTest extends IrrigationLineRepositoryTestTemplate
{
    private IrrigationLineJsonFileRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        self::bootKernel();
        $this->repository = self::getContainer()->get(IrrigationLineJsonFileRepository::class);
    }

    protected function repository(): IrrigationLineRepositoryInterface
    {
        return $this->repository;
    }
}
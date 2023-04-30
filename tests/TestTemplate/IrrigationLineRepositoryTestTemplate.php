<?php

namespace App\Tests\TestTemplate;

use App\Domain\Entity\IrrigationLine;
use App\Domain\Repository\IrrigationLineRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

abstract class IrrigationLineRepositoryTestTemplate extends KernelTestCase
{
    abstract protected function repository(): IrrigationLineRepositoryInterface;


    /** @test */
    public function add_and_get_by_identifier(): void
    {
        // given
        $givenIdentifier = 1;

        // when
        $this->repository()->save(new IrrigationLine($givenIdentifier, 'truskawki'));

        // then
        $line = $this->repository()->get($givenIdentifier);
        $this->assertInstanceOf(IrrigationLine::class, $line);
        $this->assertEquals($givenIdentifier, $line->getIdentifier());
    }

    /** @test */
    public function delete_by_identifier(): void
    {
        // given
        $givenIdentifier = 1;
        $givenLine = new IrrigationLine($givenIdentifier, 'truskawki');
        $this->repository()->save($givenLine);

        // when
        $this->repository()->delete($givenLine);

        // then
        $this->expectException(\LogicException::class);
        $this->repository()->get($givenIdentifier);
    }
}
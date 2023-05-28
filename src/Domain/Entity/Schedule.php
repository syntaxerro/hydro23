<?php

namespace App\Domain\Entity;

use App\Native\Entity\JsonDeserializableEntityTrait;
use App\Native\Entity\JsonSerializableEntityTrait;
use JsonSerializable;

class Schedule implements JsonSerializable
{
    use JsonSerializableEntityTrait;
    use JsonDeserializableEntityTrait;

    private readonly string $id;

    public function __construct(
        private int    $irrigationLineIdentifier,
        private string $startAt,
        private string $dayOfWeek,
        private string $irrigationTime,
        ?string        $id = null
    ) {
        $this->id = $id ?? uniqid(uniqid());
    }

    public function getIrrigationLineIdentifier(): int
    {
        return $this->irrigationLineIdentifier;
    }

    public function getStartAt(): string
    {
        return $this->startAt;
    }

    public function getDayOfWeek(): string
    {
        return $this->dayOfWeek;
    }

    public function getIrrigationTime(): string
    {
        return $this->irrigationTime;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setIrrigationLineIdentifier(int $irrigationLineIdentifier): void
    {
        $this->irrigationLineIdentifier = $irrigationLineIdentifier;
    }

    public function setStartAt(string $startAt): void
    {
        $this->startAt = $startAt;
    }

    public function setDayOfWeek(string $dayOfWeek): void
    {
        $this->dayOfWeek = $dayOfWeek;
    }

    public function setIrrigationTime(string $irrigationTime): void
    {
        $this->irrigationTime = $irrigationTime;
    }
}
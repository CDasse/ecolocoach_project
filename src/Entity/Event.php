<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\EventType;
use App\Repository\EventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventRepository::class)]
class Event extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: EventType::class)]
    private ?EventType $eventType = null;

    #[ORM\ManyToOne]
    private ?Level $level = null;

    #[ORM\Column(nullable: true)]
    private ?int $sequenceNumber = null;

    #[ORM\Column(nullable: true)]
    private ?float $co2Impact = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventType(): ?EventType
    {
        return $this->eventType;
    }

    public function setEventType(EventType $eventType): static
    {
        $this->eventType = $eventType;

        return $this;
    }

    public function getLevel(): ?Level
    {
        return $this->level;
    }

    public function setLevel(?Level $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    public function setSequenceNumber(?int $sequenceNumber): static
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }

    public function getCo2Impact(): ?float
    {
        return $this->co2Impact;
    }

    public function setCo2Impact(?float $co2Impact): static
    {
        $this->co2Impact = $co2Impact;

        return $this;
    }
}

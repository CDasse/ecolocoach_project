<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\EventType;
use App\Repository\XLevelEventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XLevelEventRepository::class)]
class XLevelEvent extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'xLevelEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Level $level = null;

    #[ORM\ManyToOne(inversedBy: 'xLevelEvents')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\Column(enumType: EventType::class)]
    private ?EventType $eventType = null;

    #[ORM\Column]
    private ?int $sequenceNumberEvent = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
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

    public function getSequenceNumberEvent(): ?int
    {
        return $this->sequenceNumberEvent;
    }

    public function setSequenceNumberEvent(int $sequenceNumberEvent): static
    {
        $this->sequenceNumberEvent = $sequenceNumberEvent;

        return $this;
    }
}

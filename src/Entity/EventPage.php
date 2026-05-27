<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\EventPageRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents a specific layout page configuration bound to an Event instance.
 * Serves as an intermediary structural container that aggregates atomic visual pieces
 * or informational parts, organized chronologically via sequence numbering.
 */
#[ORM\Entity(repositoryClass: EventPageRepository::class)]
class EventPage extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    private ?Event $event = null;

    #[ORM\Column(nullable: true)]
    private ?int $sequenceNumber = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    public function setSequenceNumber(?int $sequenceNumber): static
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }
}

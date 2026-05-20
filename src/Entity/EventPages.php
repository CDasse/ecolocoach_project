<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\EventPagesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventPagesRepository::class)]
class EventPages extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, Event>
     */
    #[ORM\ManyToMany(targetEntity: Event::class, inversedBy: 'eventPages')]
    private Collection $eventId;

    #[ORM\Column]
    private ?int $sequenceNumber = null;

    public function __construct()
    {
        $this->eventId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Event>
     */
    public function getEventId(): Collection
    {
        return $this->eventId;
    }

    public function addEventId(Event $eventId): static
    {
        if (!$this->eventId->contains($eventId)) {
            $this->eventId->add($eventId);
        }

        return $this;
    }

    public function removeEventId(Event $eventId): static
    {
        $this->eventId->removeElement($eventId);

        return $this;
    }

    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    public function setSequenceNumber(int $sequenceNumber): static
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\EventType;
use App\Repository\EventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, EventPages>
     */
    #[ORM\ManyToMany(targetEntity: EventPages::class, mappedBy: 'eventId')]
    private Collection $eventPages;

    public function __construct()
    {
        $this->eventPages = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, EventPages>
     */
    public function getEventPages(): Collection
    {
        return $this->eventPages;
    }

    public function addEventPage(EventPages $eventPage): static
    {
        if (!$this->eventPages->contains($eventPage)) {
            $this->eventPages->add($eventPage);
            $eventPage->addEventId($this);
        }

        return $this;
    }

    public function removeEventPage(EventPages $eventPage): static
    {
        if ($this->eventPages->removeElement($eventPage)) {
            $eventPage->removeEventId($this);
        }

        return $this;
    }
}

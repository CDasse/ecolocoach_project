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
     * @var Collection<int, EventPage>
     */
    #[ORM\ManyToMany(targetEntity: EventPage::class, mappedBy: 'eventId')]
    private Collection $eventPages;

    /**
     * @var Collection<int, XLevelEvent>
     */
    #[ORM\OneToMany(targetEntity: XLevelEvent::class, mappedBy: 'eventId', orphanRemoval: true)]
    private Collection $xLevelEvents;

    public function __construct()
    {
        $this->eventPages = new ArrayCollection();
        $this->xLevelEvents = new ArrayCollection();
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
     * @return Collection<int, EventPage>
     */
    public function getEventPages(): Collection
    {
        return $this->eventPages;
    }

    public function addEventPage(EventPage $eventPage): static
    {
        if (!$this->eventPages->contains($eventPage)) {
            $this->eventPages->add($eventPage);
            $eventPage->addEventId($this);
        }

        return $this;
    }

    public function removeEventPage(EventPage $eventPage): static
    {
        if ($this->eventPages->removeElement($eventPage)) {
            $eventPage->removeEventId($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, XLevelEvent>
     */
    public function getXLevelEvents(): Collection
    {
        return $this->xLevelEvents;
    }

    public function addXLevelEvent(XLevelEvent $xLevelEvent): static
    {
        if (!$this->xLevelEvents->contains($xLevelEvent)) {
            $this->xLevelEvents->add($xLevelEvent);
            $xLevelEvent->setEvent($this);
        }

        return $this;
    }

    public function removeXLevelEvent(XLevelEvent $xLevelEvent): static
    {
        if ($this->xLevelEvents->removeElement($xLevelEvent)) {
            // set the owning side to null (unless already changed)
            if ($xLevelEvent->getEvent() === $this) {
                $xLevelEvent->setEvent(null);
            }
        }

        return $this;
    }
}

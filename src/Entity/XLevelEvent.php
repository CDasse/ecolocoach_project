<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\EventType;
use App\Repository\XLevelEventRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, UserEventProgress>
     */
    #[ORM\OneToMany(targetEntity: UserEventProgress::class, mappedBy: 'event', orphanRemoval: true)]
    private Collection $userEventProgress;

    public function __construct()
    {
        $this->userEventProgress = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, UserEventProgress>
     */
    public function getUserEventProgress(): Collection
    {
        return $this->userEventProgress;
    }

    public function addUserEventProgress(UserEventProgress $userEventProgress): static
    {
        if (!$this->userEventProgress->contains($userEventProgress)) {
            $this->userEventProgress->add($userEventProgress);
            $userEventProgress->setEvent($this);
        }

        return $this;
    }

    public function removeUserEventProgress(UserEventProgress $userEventProgress): static
    {
        if ($this->userEventProgress->removeElement($userEventProgress)) {
            // set the owning side to null (unless already changed)
            if ($userEventProgress->getEvent() === $this) {
                $userEventProgress->setEvent(null);
            }
        }

        return $this;
    }
}

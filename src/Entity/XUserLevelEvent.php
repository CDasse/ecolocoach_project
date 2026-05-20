<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\EventStatus;
use App\Repository\XUserLevelEventRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XUserLevelEventRepository::class)]
class XUserLevelEvent extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $targetUser = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Level $level = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Event $event = null;

    #[ORM\Column(enumType: EventStatus::class)]
    private ?EventStatus $eventStatus = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTargetUser(): ?User
    {
        return $this->targetUser;
    }

    public function setTargetUser(?User $targetUser): static
    {
        $this->targetUser = $targetUser;

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

    public function getEvent(): ?Event
    {
        return $this->event;
    }

    public function setEvent(?Event $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getEventStatus(): ?EventStatus
    {
        return $this->eventStatus;
    }

    public function setEventStatus(EventStatus $eventStatus): static
    {
        $this->eventStatus = $eventStatus;

        return $this;
    }
}

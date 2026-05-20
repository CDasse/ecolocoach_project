<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\EventStatus;
use App\Repository\UserEventProgressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserEventProgressRepository::class)]
class UserEventProgress extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userEventProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $targetUser = null;

    #[ORM\ManyToOne(inversedBy: 'userEventProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?XLevelEvent $event = null;

    #[ORM\Column(enumType: EventStatus::class)]
    private ?EventStatus $status = null;

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

    public function getEvent(): ?XLevelEvent
    {
        return $this->event;
    }

    public function setEvent(?XLevelEvent $event): static
    {
        $this->event = $event;

        return $this;
    }

    public function getStatus(): ?EventStatus
    {
        return $this->status;
    }

    public function setStatus(EventStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}

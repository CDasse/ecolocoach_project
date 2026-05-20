<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\LevelStatus;
use App\Repository\UserLevelProgressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserLevelProgressRepository::class)]
class UserLevelProgress extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'userLevelProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $targetUser = null;

    #[ORM\ManyToOne(inversedBy: 'userLevelProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?XPathLevel $level = null;

    #[ORM\Column(enumType: LevelStatus::class)]
    private ?LevelStatus $status = null;

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

    public function getLevel(): ?XPathLevel
    {
        return $this->level;
    }

    public function setLevel(?XPathLevel $level): static
    {
        $this->level = $level;

        return $this;
    }

    public function getStatus(): ?LevelStatus
    {
        return $this->status;
    }

    public function setStatus(LevelStatus $status): static
    {
        $this->status = $status;

        return $this;
    }
}

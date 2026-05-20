<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\EventStatus;
use App\Repository\XUserTeamChallengeProgressRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XUserTeamChallengeProgressRepository::class)]
class XUserTeamChallengeProgress extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'xUserTeamChallengeProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $targetUser = null;

    #[ORM\ManyToOne(inversedBy: 'xUserTeamChallengeProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TeamChallengeProgress $teamChallenge = null;

    #[ORM\Column(enumType: EventStatus::class)]
    private ?EventStatus $membreStatus = null;

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

    public function getTeamChallenge(): ?TeamChallengeProgress
    {
        return $this->teamChallenge;
    }

    public function setTeamChallenge(?TeamChallengeProgress $teamChallenge): static
    {
        $this->teamChallenge = $teamChallenge;

        return $this;
    }

    public function getMembreStatus(): ?EventStatus
    {
        return $this->membreStatus;
    }

    public function setMembreStatus(EventStatus $membreStatus): static
    {
        $this->membreStatus = $membreStatus;

        return $this;
    }
}

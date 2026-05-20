<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\TeamChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamChallengeRepository::class)]
class TeamChallenge extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var Collection<int, TeamChallengePart>
     */
    #[ORM\ManyToMany(targetEntity: TeamChallengePart::class, mappedBy: 'teamChallenge')]
    private Collection $teamChallengeParts;

    /**
     * @var Collection<int, TeamChallengeProgress>
     */
    #[ORM\OneToMany(targetEntity: TeamChallengeProgress::class, mappedBy: 'teamChallenge', orphanRemoval: true)]
    private Collection $teamChallengeProgress;

    public function __construct()
    {
        $this->teamChallengeParts = new ArrayCollection();
        $this->teamChallengeProgress = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, TeamChallengePart>
     */
    public function getTeamChallengeParts(): Collection
    {
        return $this->teamChallengeParts;
    }

    public function addTeamChallengePart(TeamChallengePart $teamChallengePart): static
    {
        if (!$this->teamChallengeParts->contains($teamChallengePart)) {
            $this->teamChallengeParts->add($teamChallengePart);
            $teamChallengePart->addTeamChallenge($this);
        }

        return $this;
    }

    public function removeTeamChallengePart(TeamChallengePart $teamChallengePart): static
    {
        if ($this->teamChallengeParts->removeElement($teamChallengePart)) {
            $teamChallengePart->removeTeamChallenge($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamChallengeProgress>
     */
    public function getTeamChallengeProgress(): Collection
    {
        return $this->teamChallengeProgress;
    }

    public function addTeamChallengeProgress(TeamChallengeProgress $teamChallengeProgress): static
    {
        if (!$this->teamChallengeProgress->contains($teamChallengeProgress)) {
            $this->teamChallengeProgress->add($teamChallengeProgress);
            $teamChallengeProgress->setTeamChallenge($this);
        }

        return $this;
    }

    public function removeTeamChallengeProgress(TeamChallengeProgress $teamChallengeProgress): static
    {
        if ($this->teamChallengeProgress->removeElement($teamChallengeProgress)) {
            // set the owning side to null (unless already changed)
            if ($teamChallengeProgress->getTeamChallenge() === $this) {
                $teamChallengeProgress->setTeamChallenge(null);
            }
        }

        return $this;
    }
}

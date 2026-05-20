<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\TeamChallengeProgressRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamChallengeProgressRepository::class)]
class TeamChallengeProgress extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teamChallengeProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\ManyToOne(inversedBy: 'teamChallengeProgress')]
    #[ORM\JoinColumn(nullable: false)]
    private ?TeamChallenge $teamChallenge = null;

    #[ORM\Column]
    private ?int $numberOfCurrent = null;

    #[ORM\Column]
    private ?int $numberOfFinished = null;

    #[ORM\Column]
    private ?int $numberOfQuit = null;

    /**
     * @var Collection<int, XUserTeamChallengeProgress>
     */
    #[ORM\OneToMany(targetEntity: XUserTeamChallengeProgress::class, mappedBy: 'teamChallenge', orphanRemoval: true)]
    private Collection $xUserTeamChallengeProgress;

    public function __construct()
    {
        $this->xUserTeamChallengeProgress = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

        return $this;
    }

    public function getTeamChallenge(): ?TeamChallenge
    {
        return $this->teamChallenge;
    }

    public function setTeamChallenge(?TeamChallenge $teamChallenge): static
    {
        $this->teamChallenge = $teamChallenge;

        return $this;
    }

    public function getNumberOfCurrent(): ?int
    {
        return $this->numberOfCurrent;
    }

    public function setNumberOfCurrent(int $numberOfCurrent): static
    {
        $this->numberOfCurrent = $numberOfCurrent;

        return $this;
    }

    public function getNumberOfFinished(): ?int
    {
        return $this->numberOfFinished;
    }

    public function setNumberOfFinished(int $numberOfFinished): static
    {
        $this->numberOfFinished = $numberOfFinished;

        return $this;
    }

    public function getNumberOfQuit(): ?int
    {
        return $this->numberOfQuit;
    }

    public function setNumberOfQuit(int $numberOfQuit): static
    {
        $this->numberOfQuit = $numberOfQuit;

        return $this;
    }

    /**
     * @return Collection<int, XUserTeamChallengeProgress>
     */
    public function getXUserTeamChallengeProgress(): Collection
    {
        return $this->xUserTeamChallengeProgress;
    }

    public function addXUserTeamChallengeProgress(XUserTeamChallengeProgress $xUserTeamChallengeProgress): static
    {
        if (!$this->xUserTeamChallengeProgress->contains($xUserTeamChallengeProgress)) {
            $this->xUserTeamChallengeProgress->add($xUserTeamChallengeProgress);
            $xUserTeamChallengeProgress->setTeamChallenge($this);
        }

        return $this;
    }

    public function removeXUserTeamChallengeProgress(XUserTeamChallengeProgress $xUserTeamChallengeProgress): static
    {
        if ($this->xUserTeamChallengeProgress->removeElement($xUserTeamChallengeProgress)) {
            // set the owning side to null (unless already changed)
            if ($xUserTeamChallengeProgress->getTeamChallenge() === $this) {
                $xUserTeamChallengeProgress->setTeamChallenge(null);
            }
        }

        return $this;
    }
}

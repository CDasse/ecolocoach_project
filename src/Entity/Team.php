<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\TeamRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_TEAM_NAME', fields: ['name'])]
#[UniqueEntity(fields: ['name'], message: "Ce nom d'équipe existe déjà.")]
class Team extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, unique: true)]
    private ?string $name = null;

    #[ORM\Column (type: 'float', options: ['default' => 0.0])]
    private ?float $totalCo2Impact = 0.0;

    #[ORM\Column]
    private ?int $membresNumber = 0;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'team')]
    private Collection $users;

    /**
     * @var Collection<int, TeamLog>
     */
    #[ORM\OneToMany(targetEntity: TeamLog::class, mappedBy: 'team', orphanRemoval: true)]
    private Collection $teamLogs;

    /**
     * @var Collection<int, TeamChallengeProgress>
     */
    #[ORM\OneToMany(targetEntity: TeamChallengeProgress::class, mappedBy: 'team', orphanRemoval: true)]
    private Collection $teamChallengeProgress;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->teamLogs = new ArrayCollection();
        $this->teamChallengeProgress = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getTotalCo2Impact(): ?float
    {
        return $this->totalCo2Impact;
    }

    public function setTotalCo2Impact(float $totalCo2Impact): static
    {
        $this->totalCo2Impact = $totalCo2Impact;

        return $this;
    }

    public function getMembresNumber(): ?int
    {
        return $this->membresNumber;
    }

    public function setMembresNumber(int $membresNumber): static
    {
        $this->membresNumber = $membresNumber;

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setTeam($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getTeam() === $this) {
                $user->setTeam(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamLog>
     */
    public function getTeamLogs(): Collection
    {
        return $this->teamLogs;
    }

    public function addTeamLog(TeamLog $teamLog): static
    {
        if (!$this->teamLogs->contains($teamLog)) {
            $this->teamLogs->add($teamLog);
            $teamLog->setTeam($this);
        }

        return $this;
    }

    public function removeTeamLog(TeamLog $teamLog): static
    {
        if ($this->teamLogs->removeElement($teamLog)) {
            // set the owning side to null (unless already changed)
            if ($teamLog->getTeam() === $this) {
                $teamLog->setTeam(null);
            }
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
            $teamChallengeProgress->setTeam($this);
        }

        return $this;
    }

    public function removeTeamChallengeProgress(TeamChallengeProgress $teamChallengeProgress): static
    {
        if ($this->teamChallengeProgress->removeElement($teamChallengeProgress)) {
            // set the owning side to null (unless already changed)
            if ($teamChallengeProgress->getTeam() === $this) {
                $teamChallengeProgress->setTeam(null);
            }
        }

        return $this;
    }
}

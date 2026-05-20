<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\TeamChallengePartType;
use App\Repository\TeamChallengePartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamChallengePartRepository::class)]
class TeamChallengePart extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: TeamChallengePartType::class)]
    private ?TeamChallengePartType $teamChallengePartType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picturePath = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tag = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    /**
     * @var Collection<int, TeamChallenge>
     */
    #[ORM\ManyToMany(targetEntity: TeamChallenge::class, inversedBy: 'teamChallengeParts')]
    private Collection $teamChallenge;

    #[ORM\Column]
    private ?int $sequenceNumberPart = null;

    public function __construct()
    {
        $this->teamChallenge = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamChallengePartType(): ?TeamChallengePartType
    {
        return $this->teamChallengePartType;
    }

    public function setTeamChallengePartType(TeamChallengePartType $teamChallengePartType): static
    {
        $this->teamChallengePartType = $teamChallengePartType;

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    public function setPicturePath(?string $picturePath): static
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(?string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(?string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, TeamChallenge>
     */
    public function getTeamChallenge(): Collection
    {
        return $this->teamChallenge;
    }

    public function addTeamChallenge(TeamChallenge $teamChallenge): static
    {
        if (!$this->teamChallenge->contains($teamChallenge)) {
            $this->teamChallenge->add($teamChallenge);
        }

        return $this;
    }

    public function removeTeamChallenge(TeamChallenge $teamChallenge): static
    {
        $this->teamChallenge->removeElement($teamChallenge);

        return $this;
    }

    public function getSequenceNumberPart(): ?int
    {
        return $this->sequenceNumberPart;
    }

    public function setSequenceNumberPart(int $sequenceNumberPart): static
    {
        $this->sequenceNumberPart = $sequenceNumberPart;

        return $this;
    }
}

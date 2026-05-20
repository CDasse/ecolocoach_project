<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\TeamLogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamLogRepository::class)]
class TeamLog extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'teamLogs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Team $team = null;

    #[ORM\Column(length: 255)]
    private ?string $content = null;

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

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): static
    {
        $this->content = $content;

        return $this;
    }
}

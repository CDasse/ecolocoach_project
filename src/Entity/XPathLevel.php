<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\XPathLevelRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: XPathLevelRepository::class)]
class XPathLevel extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'xPathLevels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Path $path = null;

    #[ORM\ManyToOne(inversedBy: 'xPathLevels')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Level $level = null;

    #[ORM\Column]
    private ?int $sequenceNumberLevel = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPath(): ?Path
    {
        return $this->path;
    }

    public function setPath(?Path $path): static
    {
        $this->path = $path;

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

    public function getSequenceNumberLevel(): ?int
    {
        return $this->sequenceNumberLevel;
    }

    public function setSequenceNumberLevel(int $sequenceNumberLevel): static
    {
        $this->sequenceNumberLevel = $sequenceNumberLevel;

        return $this;
    }
}

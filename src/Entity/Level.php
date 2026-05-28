<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\LevelRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Defines a gamified progress tier or milestone bucket within a specific transition framework.
 * Acts as a sequential container that maps a cluster of operational elements (Events)
 * to a parent timeline (Path), embedding dedicated educational guidance (Tip).
 */
#[ORM\Entity(repositoryClass: LevelRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_LEVEL_NAME', fields: ['name'])]
#[UniqueEntity(fields: ['name'], message: 'Ce nom de niveau existe déjà.')]
class Level extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, unique: true)]
    private ?string $name = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Tip $tip = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?Path $path = null;

    #[ORM\Column(nullable: true)]
    private ?int $sequenceNumber = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $mascot1 = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $mascot2 = null;

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

    public function getTip(): ?Tip
    {
        return $this->tip;
    }

    public function setTip(?Tip $tip): static
    {
        $this->tip = $tip;

        return $this;
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

    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    public function setSequenceNumber(?int $sequenceNumber): static
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }

    public function getMascot1(): ?string
    {
        return $this->mascot1;
    }

    public function setMascot1(?string $mascot1): static
    {
        $this->mascot1 = $mascot1;

        return $this;
    }

    public function getMascot2(): ?string
    {
        return $this->mascot2;
    }

    public function setMascot2(?string $mascot2): static
    {
        $this->mascot2 = $mascot2;

        return $this;
    }
}

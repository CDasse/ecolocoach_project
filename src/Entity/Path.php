<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\PathRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Represents the top-level architectural framework or roadmap trajectory within the ecosystem.
 * Acts as the master timeline path designed to guide users sequentially through a predefined
 * volume of difficulty milestones (Levels).
 */
#[ORM\Entity(repositoryClass: PathRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_PATH_NAME', fields: ['name'])]
#[UniqueEntity(fields: ['name'], message: 'Ce nom de parcours existe déjà.')]
class Path extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 30, unique: true)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $nbOfLevels = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

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

    public function getNbOfLevels(): ?int
    {
        return $this->nbOfLevels;
    }

    public function setNbOfLevels(int $nbOfLevels): static
    {
        $this->nbOfLevels = $nbOfLevels;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }
}

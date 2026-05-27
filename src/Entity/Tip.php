<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\TipRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Represents an educational piece of advice or environmental eco-gesture payload.
 * Coupled with milestone checkpoints (Levels) to deliver highly contextual, actionable,
 * and practical micro-learning insights to the user during their progression.
 */
#[ORM\Entity(repositoryClass: TipRepository::class)]
class Tip extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    public function getId(): ?int
    {
        return $this->id;
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

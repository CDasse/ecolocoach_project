<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\MessageEncouragementRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

/**
 * Stores randomized psychological rewards and motivational text payloads.
 * Utilized by the ecological reporting layers to boost user retention and foster positive
 * behavioral reinforcement throughout their environmental transition journey.
 */
#[ORM\Entity(repositoryClass: MessageEncouragementRepository::class)]
class MessageEncouragement extends BaseEntity
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

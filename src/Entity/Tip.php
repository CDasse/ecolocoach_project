<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\TipRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TipRepository::class)]
class Tip extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $content = null;

    /**
     * @var Collection<int, Level>
     */
    #[ORM\OneToMany(targetEntity: Level::class, mappedBy: 'tip')]
    private Collection $levelId;

    public function __construct()
    {
        $this->levelId = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Level>
     */
    public function getLevelId(): Collection
    {
        return $this->levelId;
    }

    public function addLevelId(Level $levelId): static
    {
        if (!$this->levelId->contains($levelId)) {
            $this->levelId->add($levelId);
            $levelId->setTip($this);
        }

        return $this;
    }

    public function removeLevelId(Level $levelId): static
    {
        // set the owning side to null (unless already changed)
        if ($this->levelId->removeElement($levelId) && $levelId->getTip() === $this) {
            $levelId->setTip(null);
        }

        return $this;
    }
}

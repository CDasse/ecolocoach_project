<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\LevelRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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

    #[ORM\ManyToOne(inversedBy: 'levelId')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Tip $tip = null;

    /**
     * @var Collection<int, XPathLevel>
     */
    #[ORM\OneToMany(targetEntity: XPathLevel::class, mappedBy: 'levelId', orphanRemoval: true)]
    private Collection $xPathLevels;

    /**
     * @var Collection<int, XLevelEvent>
     */
    #[ORM\OneToMany(targetEntity: XLevelEvent::class, mappedBy: 'levelId', orphanRemoval: true)]
    private Collection $xLevelEvents;

    public function __construct()
    {
        $this->xPathLevels = new ArrayCollection();
        $this->xLevelEvents = new ArrayCollection();
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

    public function getTip(): ?Tip
    {
        return $this->tip;
    }

    public function setTip(?Tip $tip): static
    {
        $this->tip = $tip;

        return $this;
    }

    /**
     * @return Collection<int, XPathLevel>
     */
    public function getXPathLevels(): Collection
    {
        return $this->xPathLevels;
    }

    public function addXPathLevel(XPathLevel $xPathLevel): static
    {
        if (!$this->xPathLevels->contains($xPathLevel)) {
            $this->xPathLevels->add($xPathLevel);
            $xPathLevel->setLevel($this);
        }

        return $this;
    }

    public function removeXPathLevel(XPathLevel $xPathLevel): static
    {
        if ($this->xPathLevels->removeElement($xPathLevel)) {
            // set the owning side to null (unless already changed)
            if ($xPathLevel->getLevel() === $this) {
                $xPathLevel->setLevel(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, XLevelEvent>
     */
    public function getXLevelEvents(): Collection
    {
        return $this->xLevelEvents;
    }

    public function addXLevelEvent(XLevelEvent $xLevelEvent): static
    {
        if (!$this->xLevelEvents->contains($xLevelEvent)) {
            $this->xLevelEvents->add($xLevelEvent);
            $xLevelEvent->setLevel($this);
        }

        return $this;
    }

    public function removeXLevelEvent(XLevelEvent $xLevelEvent): static
    {
        if ($this->xLevelEvents->removeElement($xLevelEvent)) {
            // set the owning side to null (unless already changed)
            if ($xLevelEvent->getLevel() === $this) {
                $xLevelEvent->setLevel(null);
            }
        }

        return $this;
    }
}

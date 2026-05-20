<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\XPathLevelRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @var Collection<int, UserLevelProgress>
     */
    #[ORM\OneToMany(targetEntity: UserLevelProgress::class, mappedBy: 'level', orphanRemoval: true)]
    private Collection $userLevelProgress;

    public function __construct()
    {
        $this->userLevelProgress = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, UserLevelProgress>
     */
    public function getUserLevelProgress(): Collection
    {
        return $this->userLevelProgress;
    }

    public function addUserLevelProgress(UserLevelProgress $userLevelProgress): static
    {
        if (!$this->userLevelProgress->contains($userLevelProgress)) {
            $this->userLevelProgress->add($userLevelProgress);
            $userLevelProgress->setLevel($this);
        }

        return $this;
    }

    public function removeUserLevelProgress(UserLevelProgress $userLevelProgress): static
    {
        if ($this->userLevelProgress->removeElement($userLevelProgress)) {
            // set the owning side to null (unless already changed)
            if ($userLevelProgress->getLevel() === $this) {
                $userLevelProgress->setLevel(null);
            }
        }

        return $this;
    }
}

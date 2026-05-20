<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Repository\PathRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

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
    private ?int $nbLevels = 0;

    #[ORM\Column(type: Types::TEXT, length: 255)]
    private ?string $description = null;

    /**
     * @var Collection<int, XPathLevel>
     */
    #[ORM\OneToMany(targetEntity: XPathLevel::class, mappedBy: 'pathId', orphanRemoval: true)]
    private Collection $xPathLevels;

    /**
     * @var Collection<int, User>
     */
    #[ORM\OneToMany(targetEntity: User::class, mappedBy: 'path')]
    private Collection $users;

    public function __construct()
    {
        $this->xPathLevels = new ArrayCollection();
        $this->users = new ArrayCollection();
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

    public function getNbLevels(): ?int
    {
        return $this->nbLevels;
    }

    public function setNbLevels(int $nbLevels): static
    {
        $this->nbLevels = $nbLevels;

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
            $xPathLevel->setPath($this);
        }

        return $this;
    }

    public function removeXPathLevel(XPathLevel $xPathLevel): static
    {
        if ($this->xPathLevels->removeElement($xPathLevel)) {
            // set the owning side to null (unless already changed)
            if ($xPathLevel->getPath() === $this) {
                $xPathLevel->setPath(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setPath($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getPath() === $this) {
                $user->setPath(null);
            }
        }

        return $this;
    }
}

<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé pour un autre compte.')]
#[UniqueEntity(fields: ['username'], message: "Ce nom d'utilisateur est déjà pris. Merci d'en choisir un autre.")]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::GUID, unique: true)]
    private ?string $uid = null;

    #[ORM\Column(length: 30, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column(type: 'float', options: ['default' => 0.0])]
    private ?float $co2Impact = 0.0;

    /**
     * @var Collection<int, Follow>
     */
    #[ORM\OneToMany(targetEntity: Follow::class, mappedBy: 'followerId', orphanRemoval: true)]
    private Collection $followers;

    /**
     * @var Collection<int, Follow>
     */
    #[ORM\OneToMany(targetEntity: Follow::class, mappedBy: 'followedId', orphanRemoval: true)]
    private Collection $followed;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Path $path = null;

    #[ORM\ManyToOne(inversedBy: 'users')]
    private ?Team $team = null;

    /**
     * @var Collection<int, UserLevelProgress>
     */
    #[ORM\OneToMany(targetEntity: UserLevelProgress::class, mappedBy: 'targetUser', orphanRemoval: true)]
    private Collection $userLevelProgress;

    /**
     * @var Collection<int, UserEventProgress>
     */
    #[ORM\OneToMany(targetEntity: UserEventProgress::class, mappedBy: 'targetUser', orphanRemoval: true)]
    private Collection $userEventProgress;

    /**
     * @var Collection<int, XUserTeamChallengeProgress>
     */
    #[ORM\OneToMany(targetEntity: XUserTeamChallengeProgress::class, mappedBy: 'targetUser', orphanRemoval: true)]
    private Collection $xUserTeamChallengeProgress;

    public function __construct()
    {
        $this->followers = new ArrayCollection();
        $this->followed = new ArrayCollection();
        $this->userLevelProgress = new ArrayCollection();
        $this->userEventProgress = new ArrayCollection();
        $this->xUserTeamChallengeProgress = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Ensure the session doesn't contain actual password hashes by CRC32C-hashing them, as supported since Symfony 7.3.
     */
    public function __serialize(): array
    {
        $data = (array) $this;
        $data["\0".self::class."\0password"] = hash('crc32c', $this->password);

        return $data;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getUid(): ?string
    {
        return $this->uid;
    }

    public function setUid(string $uid): static
    {
        $this->uid = $uid;

        return $this;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): static
    {
        $this->logo = $logo;

        return $this;
    }

    public function getCo2Impact(): ?float
    {
        return $this->co2Impact;
    }

    public function setCo2Impact(float $co2Impact): static
    {
        $this->co2Impact = $co2Impact;

        return $this;
    }

    /**
     * @return Collection<int, Follow>
     */
    public function getFollowers(): Collection
    {
        return $this->followers;
    }

    public function addFollow(Follow $follow): static
    {
        if (!$this->followers->contains($follow)) {
            $this->followers->add($follow);
            $follow->setFollower($this);
        }

        return $this;
    }

    public function removeFollow(Follow $follow): static
    {
        if ($this->followers->removeElement($follow)) {
            // set the owning side to null (unless already changed)
            if ($follow->getFollower() === $this) {
                $follow->setFollower(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Follow>
     */
    public function getFollowed(): Collection
    {
        return $this->followed;
    }

    public function addFollowed(Follow $followed): static
    {
        if (!$this->followed->contains($followed)) {
            $this->followed->add($followed);
            $followed->setFollowed($this);
        }

        return $this;
    }

    public function removeFollowed(Follow $followed): static
    {
        if ($this->followed->removeElement($followed)) {
            // set the owning side to null (unless already changed)
            if ($followed->getFollowed() === $this) {
                $followed->setFollowed(null);
            }
        }

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

    public function getTeam(): ?Team
    {
        return $this->team;
    }

    public function setTeam(?Team $team): static
    {
        $this->team = $team;

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
            $userLevelProgress->setTargetUser($this);
        }

        return $this;
    }

    public function removeUserLevelProgress(UserLevelProgress $userLevelProgress): static
    {
        if ($this->userLevelProgress->removeElement($userLevelProgress)) {
            // set the owning side to null (unless already changed)
            if ($userLevelProgress->getTargetUser() === $this) {
                $userLevelProgress->setTargetUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UserEventProgress>
     */
    public function getUserEventProgress(): Collection
    {
        return $this->userEventProgress;
    }

    public function addUserEventProgress(UserEventProgress $userEventProgress): static
    {
        if (!$this->userEventProgress->contains($userEventProgress)) {
            $this->userEventProgress->add($userEventProgress);
            $userEventProgress->setTargetUser($this);
        }

        return $this;
    }

    public function removeUserEventProgress(UserEventProgress $userEventProgress): static
    {
        if ($this->userEventProgress->removeElement($userEventProgress)) {
            // set the owning side to null (unless already changed)
            if ($userEventProgress->getTargetUser() === $this) {
                $userEventProgress->setTargetUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, XUserTeamChallengeProgress>
     */
    public function getXUserTeamChallengeProgress(): Collection
    {
        return $this->xUserTeamChallengeProgress;
    }

    public function addXUserTeamChallengeProgress(XUserTeamChallengeProgress $xUserTeamChallengeProgress): static
    {
        if (!$this->xUserTeamChallengeProgress->contains($xUserTeamChallengeProgress)) {
            $this->xUserTeamChallengeProgress->add($xUserTeamChallengeProgress);
            $xUserTeamChallengeProgress->setTargetUser($this);
        }

        return $this;
    }

    public function removeXUserTeamChallengeProgress(XUserTeamChallengeProgress $xUserTeamChallengeProgress): static
    {
        if ($this->xUserTeamChallengeProgress->removeElement($xUserTeamChallengeProgress)) {
            // set the owning side to null (unless already changed)
            if ($xUserTeamChallengeProgress->getTargetUser() === $this) {
                $xUserTeamChallengeProgress->setTargetUser(null);
            }
        }

        return $this;
    }
}

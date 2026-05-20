<?php

namespace App\Entity;

use App\Entity\Impl\BaseEntity;
use App\Enum\EventPartType;
use App\Repository\EventPartRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EventPartRepository::class)]
class EventPart extends BaseEntity
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(enumType: EventPartType::class)]
    private ?EventPartType $eventPartType = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picturePath = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $question = null;

    #[ORM\Column(length: 255, nullable: true, options: ['default' => '[]'])]
    private array $answers = [];

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $rightAnswer = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $tag = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $label = null;

    /**
     * @var Collection<int, EventPage>
     */
    #[ORM\ManyToMany(targetEntity: EventPage::class, inversedBy: 'eventParts')]
    private Collection $eventPageId;

    #[ORM\Column]
    private ?int $sequenceNumber = null;

    public function __construct()
    {
        $this->eventPageId = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEventPartType(): ?EventPartType
    {
        return $this->eventPartType;
    }

    public function setEventPartType(EventPartType $eventPartType): static
    {
        $this->eventPartType = $eventPartType;

        return $this;
    }

    public function getPicturePath(): ?string
    {
        return $this->picturePath;
    }

    public function setPicturePath(string $picturePath): static
    {
        $this->picturePath = $picturePath;

        return $this;
    }

    public function getQuestion(): ?string
    {
        return $this->question;
    }

    public function setQuestion(string $question): static
    {
        $this->question = $question;

        return $this;
    }

    public function getAnswers(): array
    {
        return $this->answers;
    }

    public function setAnswers(array $answers): static
    {
        $this->answers = $answers;

        return $this;
    }

    public function getRightAnswer(): ?string
    {
        return $this->rightAnswer;
    }

    public function setRightAnswer(string $rightAnswer): static
    {
        $this->rightAnswer = $rightAnswer;

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

    public function getTag(): ?string
    {
        return $this->tag;
    }

    public function setTag(string $tag): static
    {
        $this->tag = $tag;

        return $this;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }

    /**
     * @return Collection<int, EventPage>
     */
    public function getEventPageId(): Collection
    {
        return $this->eventPageId;
    }

    public function addEventPageId(EventPage $eventPageId): static
    {
        if (!$this->eventPageId->contains($eventPageId)) {
            $this->eventPageId->add($eventPageId);
        }

        return $this;
    }

    public function removeEventPageId(EventPage $eventPageId): static
    {
        $this->eventPageId->removeElement($eventPageId);

        return $this;
    }

    public function getSequenceNumber(): ?int
    {
        return $this->sequenceNumber;
    }

    public function setSequenceNumber(int $sequenceNumber): static
    {
        $this->sequenceNumber = $sequenceNumber;

        return $this;
    }
}

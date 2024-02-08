<?php

namespace App\Entity;

use App\Repository\RecurringTaskRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: RecurringTaskRepository::class)]
class RecurringTask
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(length: 2000, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 50)]
    private ?string $recurrencePattern = null;

    #[ORM\Column]
    private ?bool $active = null;

    #[ORM\Column(length: 20)]
    private ?string $status = null;

    #[ORM\Column(length: 20)]
    private ?string $priority = null;

    #[ORM\Column]
    private ?int $assignedUserId = null;

    #[ORM\Column(type: 'json', nullable: true)]
    private ?array $tags = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $location = null;

    #[ORM\Column]
    private ?int $estimatedTime = null;

    #[ORM\Column(nullable: true)]
    private ?int $actualTimeSpent = null;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="recurringTask", orphanRemoval=true)
     */
    private ArrayCollection $comments;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'recurringTasks')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
    }

    /**
     * @return Collection
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setRecurringTask($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getRecurringTask() === $this) {
                $comment->setRecurringTask(null);
            }
        }

        return $this;
    }
// Getters and setters...

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): self
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getRecurrencePattern(): ?string
    {
        return $this->recurrencePattern;
    }

    public function setRecurrencePattern(string $recurrencePattern): self
    {
        $this->recurrencePattern = $recurrencePattern;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): self
    {
        $this->priority = $priority;

        return $this;
    }

    public function getAssignedUserId(): ?int
    {
        return $this->assignedUserId;
    }

    public function setAssignedUserId(int $assignedUserId): self
    {
        $this->assignedUserId = $assignedUserId;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getEstimatedTime(): ?int
    {
        return $this->estimatedTime;
    }

    public function setEstimatedTime(int $estimatedTime): self
    {
        $this->estimatedTime = $estimatedTime;

        return $this;
    }

    public function getActualTimeSpent(): ?int
    {
        return $this->actualTimeSpent;
    }

    public function setActualTimeSpent(?int $actualTimeSpent): self
    {
        $this->actualTimeSpent = $actualTimeSpent;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}

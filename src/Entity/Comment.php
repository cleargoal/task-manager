<?php

namespace App\Entity;

use App\Repository\CommentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CommentRepository::class)]
class Comment
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $content = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\ManyToOne(targetEntity: RecurringTask::class, inversedBy: "comments")]
    #[ORM\JoinColumn(nullable: false)]
    private ?RecurringTask $recurringTask = null;

    #[ORM\ManyToOne(targetEntity: Task::class, inversedBy: "comments")]
    #[ORM\JoinColumn(nullable: false)]
    private ?Task $task = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    // Getters and setters...

    public function getRecurringTask(): ?RecurringTask
    {
        return $this->recurringTask;
    }

    public function setRecurringTask(?RecurringTask $recurringTask): self
    {
        $this->recurringTask = $recurringTask;

        // Ensure consistency by setting the Task to null
        $this->task = null;

        return $this;
    }

    public function getTask(): ?Task
    {
        return $this->task;
    }

    public function setTask(?Task $task): self
    {
        $this->task = $task;

        // Ensure consistency by setting the RecurringTask to null
        $this->recurringTask = null;

        return $this;
    }

    // ...
}

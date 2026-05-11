<?php

declare(strict_types=1);

namespace Ksfraser\Timesheets\Entity;

class TimeEntry
{
    public const STATUS_DRAFT = 'draft';
    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_REJECTED = 'rejected';

    private ?int $id = null;
    private int $employeeId = 0;
    private string $entryDate = '';
    private float $hours = 0;
    private string $description = '';
    private int $projectId = 0;
    private int $taskId = 0;
    private string $status = self::STATUS_DRAFT;
    private ?int $approverId = null;
    private ?string $rejectionReason = null;
    private string $createdAt = '';
    private string $updatedAt = '';

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getEmployeeId(): int { return $this->employeeId; }
    public function setEmployeeId(int $employeeId): self { $this->employeeId = $employeeId; return $this; }
    public function getEntryDate(): string { return $this->entryDate; }
    public function setEntryDate(string $entryDate): self { $this->entryDate = $entryDate; return $this; }
    public function getHours(): float { return $this->hours; }
    public function setHours(float $hours): self { $this->hours = $hours; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function getProjectId(): int { return $this->projectId; }
    public function setProjectId(int $projectId): self { $this->projectId = $projectId; return $this; }
    public function getTaskId(): int { return $this->taskId; }
    public function setTaskId(int $taskId): self { $this->taskId = $taskId; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getApproverId(): ?int { return $this->approverId; }
    public function setApproverId(?int $approverId): self { $this->approverId = $approverId; return $this; }
    public function getRejectionReason(): ?string { return $this->rejectionReason; }
    public function setRejectionReason(?string $rejectionReason): self { $this->rejectionReason = $rejectionReason; return $this; }
    public function getCreatedAt(): string { return $this->createdAt; }
    public function setCreatedAt(string $createdAt): self { $this->createdAt = $createdAt; return $this; }
    public function getUpdatedAt(): string { return $this->updatedAt; }
    public function setUpdatedAt(string $updatedAt): self { $this->updatedAt = $updatedAt; return $this; }
}
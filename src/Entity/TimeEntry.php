<?php

declare(strict_types=1);

namespace Ksfraser\Timesheets\Entity;

class TimeEntry
{
    public const STATUS_DRAFT = 'Draft';
    public const STATUS_SUBMITTED = 'Submitted';
    public const STATUS_APPROVED = 'Approved';
    public const STATUS_REJECTED = 'Rejected';

    private ?int $id = null;
    private int $employeeId = 0;
    private string $date = '';
    private float $hours = 0;
    private string $activityCode = 'G01';
    private ?int $projectId = null;
    private ?int $taskId = null;
    private string $description = '';
    private string $status = self::STATUS_DRAFT;
    private ?int $approverId = null;
    private ?string $approvedDate = null;

    public function getId(): ?int { return $this->id; }
    public function setId(?int $id): self { $this->id = $id; return $this; }
    public function getEmployeeId(): int { return $this->employeeId; }
    public function setEmployeeId(int $employeeId): self { $this->employeeId = $employeeId; return $this; }
    public function getDate(): string { return $this->date; }
    public function setDate(string $date): self { $this->date = $date; return $this; }
    public function getHours(): float { return $this->hours; }
    public function setHours(float $hours): self { $this->hours = $hours; return $this; }
    public function getActivityCode(): string { return $this->activityCode; }
    public function setActivityCode(string $activityCode): self { $this->activityCode = $activityCode; return $this; }
    public function getProjectId(): ?int { return $this->projectId; }
    public function setProjectId(?int $projectId): self { $this->projectId = $projectId; return $this; }
    public function getTaskId(): ?int { return $this->taskId; }
    public function setTaskId(?int $taskId): self { $this->taskId = $taskId; return $this; }
    public function getDescription(): string { return $this->description; }
    public function setDescription(string $description): self { $this->description = $description; return $this; }
    public function getStatus(): string { return $this->status; }
    public function setStatus(string $status): self { $this->status = $status; return $this; }
    public function getApproverId(): ?int { return $this->approverId; }
    public function setApproverId(?int $approverId): self { $this->approverId = $approverId; return $this; }
    public function getApprovedDate(): ?string { return $this->approvedDate; }
    public function setApprovedDate(?string $approvedDate): self { $this->approvedDate = $approvedDate; return $this; }

    public function isOvertime(): bool
    {
        return in_array($this->activityCode, ['O01', 'OT'], true);
    }

    public function isApproved(): bool
    {
        return $this->status === self::STATUS_APPROVED;
    }

    public function isSubmitted(): bool
    {
        return $this->status === self::STATUS_SUBMITTED;
    }
}
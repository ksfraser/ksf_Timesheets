<?php

declare(strict_types=1);

namespace Ksfraser\Timesheets\Service;

use Ksfraser\Timesheets\Entity\TimeEntry;

class TimesheetsService
{
    public function validateHours(TimeEntry $entry): array
    {
        $errors = [];

        if ($entry->getHours() <= 0) {
            $errors[] = 'Hours must be greater than zero';
        }

        if ($entry->getHours() > 24) {
            $errors[] = 'Hours cannot exceed 24 per day';
        }

        if (empty($entry->getEntryDate())) {
            $errors[] = 'Entry date is required';
        }

        return ['valid' => empty($errors), 'errors' => $errors];
    }

    public function submitEntry(TimeEntry $entry): void
    {
        $entry->setStatus(TimeEntry::STATUS_SUBMITTED);
    }

    public function approveEntry(TimeEntry $entry, int $approverId): void
    {
        $entry->setStatus(TimeEntry::STATUS_APPROVED);
        $entry->setApproverId($approverId);
    }

    public function rejectEntry(TimeEntry $entry, int $approverId, string $reason): void
    {
        $entry->setStatus(TimeEntry::STATUS_REJECTED);
        $entry->setApproverId($approverId);
        $entry->setRejectionReason($reason);
    }
}
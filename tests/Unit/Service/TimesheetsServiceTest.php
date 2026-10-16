<?php

declare(strict_types=1);

namespace Ksfraser\Timesheets\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Ksfraser\Timesheets\Service\TimesheetsService;
use Ksfraser\Timesheets\Entity\TimeEntry;

class TimesheetsServiceTest extends TestCase
{
    private TimesheetsService $service;

    protected function setUp(): void
    {
        $this->service = new TimesheetsService();
    }

    public function testCanCreateTimesheetsService(): void
    {
        $this->assertInstanceOf(TimesheetsService::class, $this->service);
    }

    public function testValidateHoursWithValidEntry(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(8);
        $entry->setEntryDate('2026-05-12');

        $result = $this->service->validateHours($entry);

        $this->assertTrue($result['valid']);
        $this->assertEmpty($result['errors']);
    }

    public function testValidateHoursWithZeroHours(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(0);
        $entry->setEntryDate('2026-05-12');

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertContains('Hours must be greater than zero', $result['errors']);
    }

    public function testValidateHoursWithNegativeHours(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(-5);
        $entry->setEntryDate('2026-05-12');

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertContains('Hours must be greater than zero', $result['errors']);
    }

    public function testValidateHoursWithExcessiveHours(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(25);
        $entry->setEntryDate('2026-05-12');

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertContains('Hours cannot exceed 24 per day', $result['errors']);
    }

    public function testValidateHoursWithMissingDate(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(8);
        $entry->setEntryDate('');

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertContains('Entry date is required', $result['errors']);
    }

    public function testValidateHoursWithMultipleErrors(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(30);
        $entry->setEntryDate('');

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertCount(2, $result['errors']);
        $this->assertContains('Hours cannot exceed 24 per day', $result['errors']);
        $this->assertContains('Entry date is required', $result['errors']);
    }

    public function testSubmitEntry(): void
    {
        $entry = new TimeEntry();
        $entry->setStatus(TimeEntry::STATUS_DRAFT);

        $this->service->submitEntry($entry);

        $this->assertEquals(TimeEntry::STATUS_SUBMITTED, $entry->getStatus());
    }

    public function testApproveEntry(): void
    {
        $entry = new TimeEntry();
        $entry->setStatus(TimeEntry::STATUS_SUBMITTED);

        $this->service->approveEntry($entry, 15);

        $this->assertEquals(TimeEntry::STATUS_APPROVED, $entry->getStatus());
        $this->assertEquals(15, $entry->getApproverId());
    }

    public function testRejectEntry(): void
    {
        $entry = new TimeEntry();
        $entry->setStatus(TimeEntry::STATUS_SUBMITTED);

        $this->service->rejectEntry($entry, 15, 'Invalid hours reported');

        $this->assertEquals(TimeEntry::STATUS_REJECTED, $entry->getStatus());
        $this->assertEquals(15, $entry->getApproverId());
        $this->assertEquals('Invalid hours reported', $entry->getRejectionReason());
    }

    public function testWorkflowDraftToSubmitToApprove(): void
    {
        $entry = new TimeEntry();
        $entry->setEmployeeId(1);
        $entry->setHours(8);
        $entry->setEntryDate('2026-05-12');
        $entry->setStatus(TimeEntry::STATUS_DRAFT);

        $validation = $this->service->validateHours($entry);
        $this->assertTrue($validation['valid']);

        $this->service->submitEntry($entry);
        $this->assertEquals(TimeEntry::STATUS_SUBMITTED, $entry->getStatus());

        $this->service->approveEntry($entry, 20);
        $this->assertEquals(TimeEntry::STATUS_APPROVED, $entry->getStatus());
        $this->assertEquals(20, $entry->getApproverId());
    }

    public function testWorkflowDraftToSubmitToReject(): void
    {
        $entry = new TimeEntry();
        $entry->setEmployeeId(1);
        $entry->setHours(50);
        $entry->setEntryDate('2026-05-12');
        $entry->setStatus(TimeEntry::STATUS_DRAFT);

        $this->service->submitEntry($entry);
        $this->assertEquals(TimeEntry::STATUS_SUBMITTED, $entry->getStatus());

        $this->service->rejectEntry($entry, 20, 'Excessive hours');
        $this->assertEquals(TimeEntry::STATUS_REJECTED, $entry->getStatus());
        $this->assertEquals('Excessive hours', $entry->getRejectionReason());
    }

    public function testValidateHoursAtBoundary(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(24);
        $entry->setEntryDate('2026-05-12');

        $result = $this->service->validateHours($entry);

        $this->assertTrue($result['valid']);
    }

    public function testValidateHoursJustOverBoundary(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(24.01);
        $entry->setEntryDate('2026-05-12');

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertContains('Hours cannot exceed 24 per day', $result['errors']);
    }

    public function testMultipleEntriesValidation(): void
    {
        $entries = [];
        $validCount = 0;

        for ($i = 0; $i < 5; $i++) {
            $entry = new TimeEntry();
            $entry->setEmployeeId($i + 1);
            $entry->setHours(8);
            $entry->setEntryDate('2026-05-12');
            $entries[] = $entry;
        }

        foreach ($entries as $entry) {
            $result = $this->service->validateHours($entry);
            if ($result['valid']) {
                $validCount++;
            }
        }

        $this->assertEquals(5, $validCount);
    }
}
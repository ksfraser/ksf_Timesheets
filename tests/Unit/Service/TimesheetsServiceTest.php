<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\Timesheets\Service;

use Ksfraser\Timesheets\Entity\TimeEntry;
use Ksfraser\Timesheets\Service\TimesheetsService;
use PHPUnit\Framework\TestCase;

class TimesheetsServiceTest extends TestCase
{
    private TimesheetsService $service;

    protected function setUp(): void
    {
        $this->service = new TimesheetsService();
    }

    /**
     * @covers Ksfraser\Timesheets\Service\TimesheetsService::validateHours
     */
    public function testValidateHoursZero(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(0);
        $entry->setEntryDate('2026-05-11');

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertContains('Hours must be greater than zero', $result['errors']);
    }

    /**
     * @covers Ksfraser\Timesheets\Service\TimesheetsService::validateHours
     */
    public function testValidateHoursExceeds24(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(25);
        $entry->setEntryDate('2026-05-11');

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertContains('Hours cannot exceed 24 per day', $result['errors']);
    }

    /**
     * @covers Ksfraser\Timesheets\Service\TimesheetsService::validateHours
     */
    public function testValidateHoursNoDate(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(8);

        $result = $this->service->validateHours($entry);

        $this->assertFalse($result['valid']);
        $this->assertContains('Entry date is required', $result['errors']);
    }

    /**
     * @covers Ksfraser\Timesheets\Service\TimesheetsService::validateHours
     */
    public function testValidateHoursValid(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(8);
        $entry->setEntryDate('2026-05-11');

        $result = $this->service->validateHours($entry);

        $this->assertTrue($result['valid']);
        $this->assertEmpty($result['errors']);
    }

    /**
     * @covers Ksfraser\Timesheets\Service\TimesheetsService::submitEntry
     */
    public function testSubmitEntry(): void
    {
        $entry = new TimeEntry();
        $entry->setStatus(TimeEntry::STATUS_DRAFT);

        $this->service->submitEntry($entry);

        $this->assertSame(TimeEntry::STATUS_SUBMITTED, $entry->getStatus());
    }

    /**
     * @covers Ksfraser\Timesheets\Service\TimesheetsService::approveEntry
     */
    public function testApproveEntry(): void
    {
        $entry = new TimeEntry();
        $entry->setStatus(TimeEntry::STATUS_SUBMITTED);

        $this->service->approveEntry($entry, 999);

        $this->assertSame(TimeEntry::STATUS_APPROVED, $entry->getStatus());
        $this->assertSame(999, $entry->getApproverId());
    }

    /**
     * @covers Ksfraser\Timesheets\Service\TimesheetsService::rejectEntry
     */
    public function testRejectEntry(): void
    {
        $entry = new TimeEntry();
        $entry->setStatus(TimeEntry::STATUS_SUBMITTED);

        $this->service->rejectEntry($entry, 999, 'Incomplete');

        $this->assertSame(TimeEntry::STATUS_REJECTED, $entry->getStatus());
        $this->assertSame(999, $entry->getApproverId());
        $this->assertSame('Incomplete', $entry->getRejectionReason());
    }
}
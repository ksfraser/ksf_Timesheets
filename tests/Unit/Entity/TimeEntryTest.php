<?php

declare(strict_types=1);

namespace Ksfraser\Timesheets\Tests\Unit\Entity;

use PHPUnit\Framework\TestCase;
use Ksfraser\Timesheets\Entity\TimeEntry;

class TimeEntryTest extends TestCase
{
    public function testCanCreateTimeEntry(): void
    {
        $entry = new TimeEntry();
        $this->assertInstanceOf(TimeEntry::class, $entry);
    }

    public function testCanSetAndGetEmployeeId(): void
    {
        $entry = new TimeEntry();
        $entry->setEmployeeId(10);
        $this->assertEquals(10, $entry->getEmployeeId());
    }

    public function testCanSetAndGetEntryDate(): void
    {
        $entry = new TimeEntry();
        $entry->setEntryDate('2026-05-12');
        $this->assertEquals('2026-05-12', $entry->getEntryDate());
    }

    public function testCanSetAndGetHours(): void
    {
        $entry = new TimeEntry();
        $entry->setHours(8.5);
        $this->assertEquals(8.5, $entry->getHours());
    }

    public function testCanSetAndGetDescription(): void
    {
        $entry = new TimeEntry();
        $entry->setDescription('Working on feature X');
        $this->assertEquals('Working on feature X', $entry->getDescription());
    }

    public function testCanSetAndGetProjectId(): void
    {
        $entry = new TimeEntry();
        $entry->setProjectId(5);
        $this->assertEquals(5, $entry->getProjectId());
    }

    public function testCanSetAndGetTaskId(): void
    {
        $entry = new TimeEntry();
        $entry->setTaskId(12);
        $this->assertEquals(12, $entry->getTaskId());
    }

    public function testCanSetAndGetStatus(): void
    {
        $entry = new TimeEntry();
        $this->assertEquals(TimeEntry::STATUS_DRAFT, $entry->getStatus());
        $entry->setStatus(TimeEntry::STATUS_SUBMITTED);
        $this->assertEquals(TimeEntry::STATUS_SUBMITTED, $entry->getStatus());
    }

    public function testCanSetAndGetApproverId(): void
    {
        $entry = new TimeEntry();
        $entry->setApproverId(20);
        $this->assertEquals(20, $entry->getApproverId());
    }

    public function testCanSetAndGetRejectionReason(): void
    {
        $entry = new TimeEntry();
        $entry->setRejectionReason('Hours exceed daily limit');
        $this->assertEquals('Hours exceed daily limit', $entry->getRejectionReason());
    }

    public function testCanSetAndGetTimestamps(): void
    {
        $entry = new TimeEntry();
        $entry->setCreatedAt('2026-05-12 09:00:00');
        $entry->setUpdatedAt('2026-05-12 17:00:00');
        $this->assertEquals('2026-05-12 09:00:00', $entry->getCreatedAt());
        $this->assertEquals('2026-05-12 17:00:00', $entry->getUpdatedAt());
    }

    public function testSetAndGetId(): void
    {
        $entry = new TimeEntry();
        $entry->setId(100);
        $this->assertEquals(100, $entry->getId());
    }

    public function testFluentInterface(): void
    {
        $entry = (new TimeEntry())
            ->setEmployeeId(5)
            ->setEntryDate('2026-05-12')
            ->setHours(7.5)
            ->setDescription('Development work')
            ->setProjectId(3)
            ->setStatus(TimeEntry::STATUS_SUBMITTED);

        $this->assertEquals(5, $entry->getEmployeeId());
        $this->assertEquals('2026-05-12', $entry->getEntryDate());
        $this->assertEquals(7.5, $entry->getHours());
        $this->assertEquals('Development work', $entry->getDescription());
        $this->assertEquals(3, $entry->getProjectId());
        $this->assertEquals(TimeEntry::STATUS_SUBMITTED, $entry->getStatus());
    }

    public function testAllStatusConstantsExist(): void
    {
        $this->assertEquals('draft', TimeEntry::STATUS_DRAFT);
        $this->assertEquals('submitted', TimeEntry::STATUS_SUBMITTED);
        $this->assertEquals('approved', TimeEntry::STATUS_APPROVED);
        $this->assertEquals('rejected', TimeEntry::STATUS_REJECTED);
    }

    public function testDefaultStatusIsDraft(): void
    {
        $entry = new TimeEntry();
        $this->assertEquals(TimeEntry::STATUS_DRAFT, $entry->getStatus());
    }

    public function testDefaultHoursIsZero(): void
    {
        $entry = new TimeEntry();
        $this->assertEquals(0, $entry->getHours());
    }

    public function testDefaultIdsAreZero(): void
    {
        $entry = new TimeEntry();
        $this->assertEquals(0, $entry->getEmployeeId());
        $this->assertEquals(0, $entry->getProjectId());
        $this->assertEquals(0, $entry->getTaskId());
    }

    public function testNullableFieldsReturnNullWhenNotSet(): void
    {
        $entry = new TimeEntry();
        $this->assertNull($entry->getApproverId());
        $this->assertNull($entry->getRejectionReason());
    }
}
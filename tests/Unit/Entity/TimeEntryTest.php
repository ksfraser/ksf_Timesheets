<?php

declare(strict_types=1);

namespace Ksfraser\Tests\Unit\Timesheets\Entity;

use Ksfraser\Timesheets\Entity\TimeEntry;
use PHPUnit\Framework\TestCase;

class TimeEntryTest extends TestCase
{
    public function testDefaultValues(): void
    {
        $entry = new TimeEntry();

        $this->assertNull($entry->getId());
        $this->assertSame(0, $entry->getEmployeeId());
        $this->assertSame('', $entry->getEntryDate());
        $this->assertSame(0.0, $entry->getHours());
        $this->assertSame('', $entry->getDescription());
        $this->assertSame(0, $entry->getProjectId());
        $this->assertSame(0, $entry->getTaskId());
        $this->assertSame(TimeEntry::STATUS_DRAFT, $entry->getStatus());
        $this->assertNull($entry->getApproverId());
        $this->assertNull($entry->getRejectionReason());
    }

    /**
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::setId
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::getId
     */
    public function testSetId(): void
    {
        $entry = new TimeEntry();
        $result = $entry->setId(123);

        $this->assertInstanceOf(TimeEntry::class, $result);
        $this->assertSame(123, $entry->getId());
    }

    /**
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::setEmployeeId
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::getEmployeeId
     */
    public function testSetEmployeeId(): void
    {
        $entry = new TimeEntry();
        $result = $entry->setEmployeeId(456);

        $this->assertInstanceOf(TimeEntry::class, $result);
        $this->assertSame(456, $entry->getEmployeeId());
    }

    /**
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::setHours
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::getHours
     */
    public function testSetHours(): void
    {
        $entry = new TimeEntry();
        $result = $entry->setHours(8.5);

        $this->assertInstanceOf(TimeEntry::class, $result);
        $this->assertSame(8.5, $entry->getHours());
    }

    /**
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::setStatus
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::getStatus
     */
    public function testStatusConstants(): void
    {
        $this->assertSame('draft', TimeEntry::STATUS_DRAFT);
        $this->assertSame('submitted', TimeEntry::STATUS_SUBMITTED);
        $this->assertSame('approved', TimeEntry::STATUS_APPROVED);
        $this->assertSame('rejected', TimeEntry::STATUS_REJECTED);
    }

    /**
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::setEntryDate
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::getEntryDate
     */
    public function testSetEntryDate(): void
    {
        $entry = new TimeEntry();
        $result = $entry->setEntryDate('2026-05-11');

        $this->assertInstanceOf(TimeEntry::class, $result);
        $this->assertSame('2026-05-11', $entry->getEntryDate());
    }

    /**
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::setApproverId
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::getApproverId
     */
    public function testSetApproverId(): void
    {
        $entry = new TimeEntry();
        $result = $entry->setApproverId(789);

        $this->assertInstanceOf(TimeEntry::class, $result);
        $this->assertSame(789, $entry->getApproverId());
    }

    /**
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::setProjectId
     * @covers Ksfraser\Timesheets\Entity\TimeEntry::getProjectId
     */
    public function testSetProjectId(): void
    {
        $entry = new TimeEntry();
        $result = $entry->setProjectId(100);

        $this->assertInstanceOf(TimeEntry::class, $result);
        $this->assertSame(100, $entry->getProjectId());
    }
}
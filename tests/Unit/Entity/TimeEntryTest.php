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
        $entry->setEmployeeId(1);
        $this->assertEquals(1, $entry->getEmployeeId());
    }

    public function testCanSetAndGetActivityCode(): void
    {
        $entry = new TimeEntry();
        $entry->setActivityCode('G01');
        $this->assertEquals('G01', $entry->getActivityCode());
    }

    public function testCanSetDateAndHours(): void
    {
        $entry = new TimeEntry();
        $entry->setDate('2024-07-15');
        $entry->setHours(8);
        $this->assertEquals('2024-07-15', $entry->getDate());
        $this->assertEquals(8, $entry->getHours());
    }

    public function testCanSetStatus(): void
    {
        $entry = new TimeEntry();
        $entry->setStatus(TimeEntry::STATUS_SUBMITTED);
        $this->assertEquals(TimeEntry::STATUS_SUBMITTED, $entry->getStatus());
    }

    public function testCanCheckIsOvertime(): void
    {
        $entry = new TimeEntry();
        $entry->setActivityCode('O01');
        $this->assertTrue($entry->isOvertime());
        
        $entry->setActivityCode('G01');
        $this->assertFalse($entry->isOvertime());
    }
}
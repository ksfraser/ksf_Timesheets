# Architecture - ksf_Timesheets

## Document Information
- **Module**: ksf_Timesheets
- **Version**: 1.0.0
- **Date**: 2026-05-24
- **Status**: Draft
- **Author**: KSFII Development Team

---

## 1. Module Overview

ksf_Timesheets provides time tracking and timesheet management for project-based billing, payroll integration, and productivity analysis.

### 1.1 Namespace
```php
Ksfraser\Timesheets\
```

### 1.2 Layer Pattern
```
ksf_Timesheets/              → Business Logic
    ├── Entity/              → Domain entities
    ├── Service/             → Business services
    ├── Repository/          → Data access interfaces
    ├── Contract/            → Interfaces for adapters
    └── Exception/           → Domain exceptions
```

---

## 2. Core Entities

### 2.1 Timesheet
```php
class Timesheet {
    private string $id;
    private string $employeeId;
    private \DateTime $periodStart;
    private \DateTime $periodEnd;
    private TimesheetStatus $status;    // draft, submitted, approved, rejected
    private ?string $approverId;
    private ?\DateTime $approvedAt;
    private float $totalHours;
    private string $notes;
}
```

### 2.2 TimeEntry
```php
class TimeEntry {
    private string $id;
    private string $timesheetId;
    private \DateTime $date;
    private string $projectId;          // FK to ksf_ProjectManagement
    private ?string $taskId;            // FK to project task
    private float $hours;
    private string $description;
    private ?string $billableRateCode;
    private bool $isBillable;
    private TimeEntryType $type;        // regular, overtime, holiday
}
```

---

## 3. RBAC Integration (ksfraser/rbac)

### 3.1 Module Registration

ksf_Timesheets registers with ksfraser/rbac:
- record_types: 'timesheet', 'time_entry'
- projections: 'public' (employee_id, period, status, total_hours), 'full' (all fields including billable rates, approval chain, project costing)
- allow_invite: false
- children: time_entry (child of timesheet)

### 3.2 Entity Projections

| Entity | PUBLIC Fields | FULL Fields |
|--------|---------------|-------------|
| Timesheet | employee_id, period_start, period_end, status, total_hours | + approver_id, approved_at, notes, billing_summary |
| TimeEntry | date, project_id, task_id, hours, description | + billable_rate_code, is_billable, cost_center, overtime_type |

### 3.3 Access Model

- **Employee**: Create/edit own timesheets (via {userId}_individual team), view own at PROJECTION_FULL
- **Manager/Team Lead**: View team timesheets (via org_direct team), approve/reject
- **Project Manager**: View time entries linked to own projects (PROJECTION_PUBLIC)
- **Payroll/Finance**: View approved timesheets (PROJECTION_FULL), can_export for payroll
- **HR**: View timesheet summary for attendance (PROJECTION_PUBLIC)

### 3.4 SQL Enforcement

All timesheet queries MUST JOIN against 0_rbac_record_access:
```sql
JOIN 0_rbac_record_access ra
  ON ra.record_id    = t.id
 AND ra.record_type  = 'timesheet'
 AND ra.module       = 'timesheets'
 AND ra.inactive     = 0
 AND ra.can_view     = 1
JOIN 0_rbac_team_members tm
  ON tm.team_id  = ra.team_id
 AND tm.user_id  = :currentUserId
 AND tm.inactive = 0
```

### 3.5 Soft Delete

- Timesheets use soft delete (deleted=1, deleted_by, deleted_at)
- Time entries cascade with parent timesheet
- Hard delete is super-admin only

### 3.6 Calendar Integration

Time entries may sync to ksf_Calendar as 'timetracking' type entries via PSR-14 event. Calendar visibility is gated separately by ksf_Calendar's own RBAC registration.

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-24*

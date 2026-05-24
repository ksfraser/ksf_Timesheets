# Functional Requirements - ksf_Timesheets

## Document Information
- **Module**: ksf_Timesheets
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Status**: Proposed
- **Author**: KSFII Development Team

## 1. Overview

### 1.1 Purpose
ksf_Timesheets provides time tracking linked to projects and billing/payroll calculation.

### 1.2 Scope
- Weekly timesheet entry
- Project/task linking
- Activity codes
- Manager approval
- Billing calculation

## 2. Core Entities

### 2.1 ActivityCode

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| code | string | Yes | G01, O01, V01, S01, P01, B01 |
| name | string | Yes | Activity name |
| rate_multiplier | float | Yes | 1.0 for regular, 1.5 for OT |
| is_billable | bool | Yes | Default true |
| is_leave | bool | Yes | Default false |
| liability_type | string | No | Payable/Vacation/Sick/Personal |

### 2.2 Timesheet

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| employee_id | string | Yes | FK to Employee |
| week_start | Date | Yes | Monday of week |
| status | string | Yes | draft/submitted/approved/rejected/processed |
| submitted_at | DateTime | No | Submission time |
| approved_by | string | No | Approver user ID |
| approved_at | DateTime | No | Approval time |
| total_hours | float | Yes | Computed total |
| created_at | DateTime | Yes | Auto |
| updated_at | DateTime | Yes | Auto |

### 2.3 TimeEntry

| Field | Type | Required | Description |
|-------|------|----------|-------------|
| id | string | Yes | UUID |
| timesheet_id | string | Yes | FK to Timesheet |
| project_id | string | No | FK to Project |
| task_id | string | No | FK to Task |
| activity_code_id | string | Yes | FK to ActivityCode |
| entry_date | Date | Yes | Date of work |
| hours | float | Yes | Hours worked |
| notes | string | No | Description of work |
| is_manual | bool | Yes | Default true |
| source | string | Yes | manual/leave/project |
| created_at | DateTime | Yes | Auto |

## 3. Functional Requirements

### FR-TS-001: Timesheet Entry
**Requirement**: System shall allow weekly time entry.

**Features**:
- Weekly view (Mon-Sun)
- Daily hour entry
- Select project and task
- Select activity code
- Add notes per entry
- Save draft or submit

### FR-TS-002: Project/Task Integration
**Requirement**: System shall link time to projects and tasks.

**Features**:
- Select from active projects
- Filter tasks by project
- Update task actual hours
- Validate project is active

### FR-TS-003: Activity Codes
**Requirement**: System shall track time by activity type.

**Standard Codes**:
| Code | Name | Rate | Use |
|------|------|------|-----|
| G01 | Regular | 1.0× | Regular work |
| O01 | Overtime | 1.5× | OT hours |
| V01 | Vacation | 1.0× | Vacation leave |
| S01 | Sick | 1.0× | Sick leave |
| P01 | Personal | 1.0× | Personal leave |
| B01 | Bereavement | 1.0× | Bereavement |

### FR-TS-004: Manager Approval
**Requirement**: System shall route timesheets for approval.

**Features**:
- Submit to manager
- Manager review entries
- Approve/reject with comments
- Bulk approval option
- Auto-reminder on Friday

### FR-TS-005: RBAC Integration
**Requirement**: System shall enforce role-based access control via ksfraser/rbac.

**Features**:
- Register record types 'timesheet', 'time_entry' with RBAC
- Apply RBAC JOIN on all data queries
- PUBLIC projection restricts non-sensitive fields
- FULL projection available for authorized roles only

### FR-TS-006: DTO Projections
**Requirement**: System shall use RBAC-aware DTOs for all data access.

**Features**:
- TimesheetDTO maps PUBLIC/FULL fields based on user role
- TimeEntryDTO applies field-level filtering
- Projection level determined by RBAC team membership
- Admin override for super-admin role

### FR-TS-007: Soft Delete
**Requirement**: System shall support soft deletion of timesheets and cascading time entries.

**Features**:
- Timesheets set deleted=1, deleted_by, deleted_at
- Time entries cascade soft delete with parent
- Hard delete restricted to super-admin
- Deleted records excluded from all standard queries
- Retention period configurable via settings

### FR-TS-008: Audit Trail
**Requirement**: System shall log all RBAC-sensitive operations.

**Features**:
- Log timesheet status changes (submit, approve, reject)
- Log projection level downgrade attempts
- Log soft delete and restore operations
- Audit trail viewable by HR and super-admin

### FR-TS-009: Calendar Sync
**Requirement**: System shall sync time entries to ksf_Calendar via PSR-14 event.

**Features**:
- Emit 'timesheet.approved' event for calendar sync
- Time entries appear as 'timetracking' type calendar events
- Calendar visibility gated by ksf_Calendar RBAC
- Sync only approved/relevant entries

### FR-TS-010: Billing Calculation
**Requirement**: System shall calculate billing amounts.

**Formula**:
```
Line Amount = Hours × Activity Rate × Employee Hourly Rate
```

**Features**:
- Get employee rate from HRM
- Apply activity multiplier
- Generate line items for invoice

### FR-TS-011: Payroll Export
**Requirement**: System shall export data for payroll.

**Features**:
- Aggregate by employee and activity
- Calculate liability:
  - G01, B01 → Wages Payable
  - O01 → Overtime Payable
  - V01, S01, P01 → Leave Liability
- Export CSV for payroll system

## 4. Business Logic

### 4.1 Total Hours
```php
public function getTotalHours(): float
// Sum of all time entry hours
```

### 4.2 Billing Amount
```php
public function calculateBillingAmount(TimeEntry $entry, float $hourlyRate): float
// entry.hours × activity.rate_multiplier × hourlyRate
```

## 5. Integration Events (PSR-14)

| Event | Trigger |
|-------|---------|
| `timesheet.submitted` | Timesheet submitted |
| `timesheet.approved` | Timesheet approved |
| `timesheet.rejected` | Timesheet rejected |
| `time_entry.created` | New time entry |

## 6. Composer Dependencies

| Package | Version | Purpose |
|---------|---------|---------|
| ksfraser/exceptions | ^1.3 | Exception hierarchy |
| psr/event-dispatcher | ^2.0 | PSR-14 events |

---

*Document Version: 1.1.0*
*Last Updated: 2026-05-11*
# Test Plan - ksf_Timesheets

## Document Information
- **Module**: ksf_Timesheets
- **Version**: 1.0.0
- **Date**: 2026-05-11
- **Test Framework**: PHPUnit 10.x

## 1. Test Strategy

### 1.1 Coverage Target
- 100% line/branch coverage
- Exception classes excluded

## 2. Test Structure

```
ksf_Timesheets/tests/
├── bootstrap.php
└── Unit/
    ├── Entity/
    │   ├── ActivityCodeTest.php
    │   ├── TimesheetTest.php
    │   └── TimeEntryTest.php
    └── Service/
        └── TimesheetServiceTest.php
```

## 3. Test Cases

### 3.1 TimesheetTest

| Test | Description |
|------|-------------|
| testCreateTimesheet | Valid timesheet created |
| testWeekStartValidation | Monday validation |
| testCalculateTotalHours | Sum of entries |
| testSubmitTimesheet | Status → submitted |
| testApproveTimesheet | Status → approved |
| testRejectTimesheet | Status → rejected |
| testLockApprovedEntries | No editing after approval |

### 3.2 TimeEntryTest

| Test | Description |
|------|-------------|
| testCreateTimeEntry | Valid entry created |
| testHoursValidation | 0 < hours ≤ 24 |
| testLinkToProject | Links to project |
| testLinkToTask | Links to task |
| testCalculateBilling | Amount calculation |

### 3.3 TimesheetServiceTest

| Test | Description |
|------|-------------|
| testCreateWeeklyTimesheet | Creates for week |
| testAddTimeEntry | Entry added to timesheet |
| testSubmitForApproval | Status updated, event |
| testApproveTimesheet | Status approved, project updated |
| testCalculateBillingAmounts | Generate line items |
| testGeneratePayrollExport | CSV generation |

## 4. Quality Gates

- [ ] All unit tests pass
- [ ] Code coverage ≥ 80%
- [ ] phpstan level 8 passes
- [ ] phpcs passes PSR-12

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*
# UAT Plan - ksf_Timesheets

## Document Information
- **Module**: ksf_Timesheets
- **Version**: 1.0.0
- **Date**: 2026-05-11

## 1. UAT Overview

### 1.1 Purpose
Validate Timesheet functionality: time entry, approval, billing calculation.

### 1.2 Modules Integrated
- ksf_HRM
- ksf_ProjectManagement
- ksf_Leave

## 2. UAT Scenarios

### UAT-TS-001: Weekly Time Entry
**Scenario**: Employee enters weekly timesheet

**Steps**:
1. Navigate to Timesheets > My Timesheet
2. View current week
3. Enter time for each day:
   - Monday: 8h on Project Alpha, Task A, G01
   - Tuesday: 8h on Project Alpha, Task B, G01
   - Wednesday: 2h Project Alpha + 6h Meeting, G01
   - etc.
4. Save as draft
5. Submit for approval

**Expected Results**:
- [ ] Entries saved
- [ ] Total hours calculated (40h)
- [ ] Submitted to manager
- [ ] Manager notified

**Status**: ☐ Pass  ☐ Fail  ☐ N/A

---

### UAT-TS-002: Manager Approves Timesheet
**Scenario**: Manager approves employee's timesheet

**Steps**:
1. Manager receives notification
2. View employee's timesheet
3. Review entries by project and task
4. Check total hours (40h expected)
5. Click Approve
6. Verify timesheet locked

**Expected Results**:
- [ ] Status = Approved
- [ ] Entries locked
- [ ] Project actuals updated
- [ ] Ready for payroll

**Status**: ☐ Pass  ☐ Fail  ☐ N/A

---

### UAT-TS-003: Time Entry from Task
**Scenario**: Employee logs time from project task

**Steps**:
1. Open assigned task in PM
2. Click "Log Time"
3. Pre-filled: Project, Task, Date
4. Enter 4 hours
5. Save
6. Verify appears in timesheet

**Expected Results**:
- [ ] Entry created
- [ ] Task actual hours updated
- [ ] Timesheet updated

**Status**: ☐ Pass  ☐ Fail  ☐ N/A

---

### UAT-TS-004: Leave Auto-Entry
**Scenario**: Vacation approved, auto-creates timesheet entry

**Steps**:
1. Leave approved for Monday
2. System auto-creates timesheet entry:
   - Activity: V01 (Vacation)
   - Hours: 8
   - Date: Monday
3. Employee views timesheet
4. Can adjust if needed

**Expected Results**:
- [ ] Entry auto-created
- [ ] Correct activity code
- [ ] Employee can modify

**Status**: ☐ Pass  ☐ Fail  ☐ N/A

---

### UAT-TS-005: Project Billing Report
**Scenario**: PM views project time and billing

**Steps**:
1. Navigate to Project > Time Reports
2. Select project and date range
3. View:
   - Total hours: 320h
   - By employee
   - By task
   - By activity type
   - Billing amount: $12,800
4. Export to Excel

**Expected Results**:
- [ ] Accurate time totals
- [ ] Billing calculation correct
- [ ] Export successful

**Status**: ☐ Pass  ☐ Fail  ☐ N/A

---

### UAT-TS-006: Payroll Export
**Scenario**: Finance exports timesheet data for payroll

**Steps**:
1. Navigate to Timesheets > Payroll Export
2. Select pay period
3. Preview data:
   - Employee: John Doe
   - G01: 160h @ $25 = $4,000
   - O01: 20h @ $37.50 = $750
   - V01: 40h @ $25 = $1,000 (liability)
4. Export CSV
5. Import to payroll system

**Expected Results**:
- [ ] Accurate calculations
- [ ] Correct format
- [ ] Liability amounts correct

**Status**: ☐ Pass  ☐ Fail  ☐ N/A

---

## 3. Sign-Off

| Role | Name | Signature | Date |
|------|------|-----------|------|
| Business Owner | | | |
| UAT Lead | | | |
| Technical Lead | | | |

---

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*
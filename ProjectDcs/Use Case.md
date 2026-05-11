# Use Cases - ksf_Timesheets

## UC-TS-001: Submit Weekly Timesheet
**Actor**: Employee

**Preconditions**: Employee has timesheet enabled

**Flow**:
1. Navigate to Timesheets > My Timesheet
2. System displays current week (Mon-Sun)
3. For each day, enter time entries:
   - Select project (ksf_ProjectManagement)
   - Select task (filtered by project)
   - Enter hours (0.25 increments)
   - Select activity code:
     - G01: Regular time
     - O01: Overtime
     - V01: Vacation
     - S01: Sick
     - P01: Personal
   - Add notes (optional)
4. System calculates daily totals
5. Employee can:
   - Save draft (continue later)
   - Submit for approval
6. System validates:
   - Hours within limits (max 12/day)
   - Activity codes valid for employee type
   - Project still active
7. On submission:
   - Status → 'Submitted'
   - Notifies manager (ksf_Workflow)

**Alternate Flow - Leave Auto-Entry**:
1. When leave approved (ksf_Leave):
2. System auto-creates timesheet entry:
   - Activity: V01, S01, P01
   - Hours: 8 (or scheduled hours)
   - No notes needed
3. Employee can adjust if needed

---

## UC-TS-002: Manager Timesheet Approval
**Actor**: Manager

**Trigger**: Employee submits timesheet

**Flow**:
1. Manager receives notification
2. Views employee's timesheet:
   - Week, employee name
   - All time entries by project/task
   - Activity codes, hours, notes
   - Total hours by day and week
3. Manager options:
   - Approve: All entries approved
   - Reject: Select specific entries to reject, enter reason
   - Return: Request clarification
4. On approval:
   - Status → 'Approved'
   - Entries locked (no more edits)
   - Ready for payroll processing
   - Project actuals updated (ksf_ProjectManagement)
5. On rejection:
   - Status → 'Rejected'
   - Employee notified with reason
   - Employee can correct and resubmit

---

## UC-TS-003: Time Entry from Task
**Actor**: Employee

**Trigger**: Employee working on project task

**Flow**:
1. Employee opens assigned task (ksf_ProjectManagement)
2. Clicks "Log Time"
3. Pre-filled form:
   - Project (from task)
   - Task (current task)
   - Date (today default)
   - Activity code (G01 default)
4. Enter hours worked
5. Save
6. System:
   - Adds to timesheet
   - Updates task actual hours
   - Shows in daily timesheet view

---

## UC-TS-004: Timesheet Reminder
**Actor**: System

**Trigger**: Friday 4:00 PM (or config time)

**Flow**:
1. System queries all unsubmitted timesheets
2. For each employee with incomplete timesheet:
   - Send reminder email (ksf_EmailManager)
   - Include direct link to timesheet
   - Remind of deadline (e.g., Monday 9 AM)
3. System continues daily reminders until:
   - Timesheet submitted
   - Or 3 reminders sent

---

## UC-TS-005: Overtime Alert
**Actor**: System, Manager

**Trigger**: Timesheet entry with O01 activity

**Flow**:
1. Employee enters O01 (overtime) hours
2. System checks:
   - Weekly total hours
   - Overtime threshold (e.g., 40 hours)
3. If approaching/exceeding threshold:
   - Show warning to employee
   - Notify manager (if over threshold)
4. Manager can:
   - Approve overtime
   - Request adjustment
   - Deny overtime entry

---

## UC-TS-006: Project Time Reporting
**Actor**: Project Manager, Finance

**Flow**:
1. Navigate to Project > Time Reports
2. Select project, date range
3. View report:
   - Total hours by employee
   - Hours by task
   - Hours by activity type
   - Billing amount
4. Export options: PDF, Excel
5. For billing:
   - Calculate line items
   - Generate invoice data
   - Send to accounting (FA)

---

## UC-TS-007: Payroll Export
**Actor**: HR/Finance, System

**Trigger**: Weekly payroll processing

**Flow**:
1. System queries approved timesheets for pay period
2. For each employee:
   - Aggregate hours by activity code
   - Get employee rate from ksf_HRM
   - Calculate liability:
     - G01, B01 → Payable wages
     - O01 → Overtime wages
     - V01, S01, P01 → Leave liability
3. Generate payroll export file:
   - Employee ID, hours, rate, amount
   - Activity code breakdown
   - Total for each category
4. Export formats:
   - CSV for payroll system
   - Direct API integration
5. HR imports to payroll system
6. System marks timesheets as 'Processed'

---

## UC-TS-008: Timesheet Correction
**Actor**: Employee (with approval), HR

**Flow**:
1. Employee requests correction:
   - Select past timesheet
   - Identify error
   - Enter correction reason
2. If timesheet is 'Approved':
   - Requires manager/HR approval
   - ksf_Workflow triggers approval
3. If timesheet is 'Submitted' (not yet approved):
   - Employee can edit directly
   - Re-submit for approval
4. On correction approval:
   - Original entry preserved (audit)
   - Correction entry created
   - Payroll recalculated if needed
5. Notification sent to affected parties

---

## UC-TS-009: Timesheet Calendar View
**Actor**: Employee, Manager

**Flow**:
1. Navigate to Timesheets > Calendar View
2. Display shows:
   - Daily hours as blocks
   - Color-coded by project/activity
   - Total hours per day
3. Employee sees personal entries
4. Manager sees:
   - Team member time blocks
   - Team capacity visualization
5. Click on entry → edit detail
6. Integration with ksf_Calendar shows:
   - Calendar events
   - Time entries overlaid
   - Helps identify meeting time

---

## UC-TS-010: Timesheet Approval Delegation
**Actor**: Manager

**Trigger**: Manager on vacation/unavailable

**Flow**:
1. Manager sets delegation in profile (ksf_Workflow)
2. Specifies:
   - Delegate (another manager)
   - Duration (dates)
   - Which timesheets to delegate
3. During delegation period:
   - Delegate receives timesheet approvals
   - Original manager can still view but not act
   - Delegation logged in audit
4. After period ends:
   - Normal approval routing resumes

---

## UC-TS-011: Utilization Report
**Actor**: Management, HR

**Flow**:
1. Navigate to Reports > Utilization
2. Set filters:
   - Date range
   - Department/Team
   - Employee (optional)
3. Report shows:
   - Capacity hours (available work hours)
   - Billable hours (G01 on projects)
   - Non-billable hours (meetings, admin)
   - Utilization % = Billable / Capacity
4. Charts:
   - By employee
   - By department
   - By project
5. Export for presentations

---

## UC-TS-012: Holiday/Leave Hours Processing
**Actor**: System

**Trigger**: Holiday, or leave taken during timesheet period

**Flow**:
1. On holiday date (ksf_Leave):
   - System identifies affected employees
2. For each employee:
   - If on approved leave (V01, S01, P01):
     - Create timesheet entry
     - 8 hours (or scheduled hours)
     - Activity matching leave type
     - Project: 'General' or blank
   - If not on leave but holiday:
     - Create Holiday entry (H01)
     - 8 hours credit
3. Employee can adjust if not accurate
4. On timesheet approval:
   - Leave balance updated (ksf_Leave)
   - Liability recorded (ksf_HRM)

*Document Version: 1.0.0*
*Last Updated: 2026-05-11*
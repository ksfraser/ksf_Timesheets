# Business Requirements - ksf_Timesheets

## Project Overview
Timesheet management tied to Project Management - tracks time worked, generates billing and payroll records.

## Problem Statement
- Need timesheet entry for employee time
- Time must relate to project/task
- Need activity codes for billing rates
- Must generate payroll liability entries
- Must tie to Calendar events

## Stakeholders
- Employees (enter time)
- Managers (approve)
- Project Managers (view project time)
- Finance (billing, payroll)

## Scope

### Activity Codes & Rates
| Code | Description | Rate | Liability |
|------|-------------|------|------------|
| G01 | Regular Time | 1.0×hourly | Payable |
| O01 | Overtime | 1.5×hourly | Payable |
| V01 | Vacation | 1.0×hourly | V01 Liability |
| S01 | Sick | 1.0×hourly | S01 Liability |
| P01 | Personal | 1.0×hourly | P01 Liability |
| B01 | Bereavement | 1.0×hourly | Payable |

### Timesheet Entry
- Weekly view (Mon-Sun)
- Select project, task
- Enter hours per day per activity
- Notes per entry

### Approval Flow
- Employee submits timesheet
- Manager approves/rejects
- Auto-reminder on Friday

### Integration
- **Project Management**: Links time to project/task
- **HRM**: Gets employee rate
- **Calendar**: Events show time entries
- **Billing**: Line items for invoice
- **Payroll**: Liability entries

### Billing Calculation
```
Hours × Activity Rate × Employee Hourly = Line Amount
```

### Payroll Calculation  
```
Hours × Activity Rate × Employee Hourly = Liability
G01: 40 × $20 = $800 (wages payable)
O01: 10 × $30 = $300 (overtime payable)
V01: 40 × $20 = $800 (vacation accrual)
S01: 8 × $20 = $160 (sick accrual)
```

## Out of Scope
- Payroll processing (external system)
- Leave request (ksf_Leave)
<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

require_login();

$page_title = "Attendance Report";
include '../../includes/header.php';

// Default to current month and year
$month = isset($_GET['month']) ? (int)$_GET['month'] : date('n');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

// Get all employees
$employees = get_all_employees();
?>

<h2>Attendance Report - <?php echo date('F Y', mktime(0, 0, 0, $month, 1, $year)); ?></h2>

<form method="GET" class="filter-form">
    <div class="form-group">
        <label for="month">Month:</label>
        <select id="month" name="month">
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?php echo $m; ?>" <?php echo $m == $month ? 'selected' : ''; ?>>
                    <?php echo date('F', mktime(0, 0, 0, $m, 1)); ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
    <div class="form-group">
        <label for="year">Year:</label>
        <select id="year" name="year">
            <?php for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++): ?>
                <option value="<?php echo $y; ?>" <?php echo $y == $year ? 'selected' : ''; ?>>
                    <?php echo $y; ?>
                </option>
            <?php endfor; ?>
        </select>
    </div>
    <button type="submit" class="btn">Generate Report</button>
</form>

<table class="attendance-report">
    <thead>
        <tr>
            <th>Employee</th>
            <th>Present</th>
            <th>Absent</th>
            <th>Late</th>
            <th>Half Days</th>
            <th>On Leave</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $employee): 
            $attendance = get_monthly_attendance($employee['employee_id'], $month, $year);
            $counts = [
                'present' => 0,
                'absent' => 0,
                'late' => 0,
                'half-day' => 0,
                'on-leave' => 0
            ];
            
            foreach ($attendance as $record) {
                if (isset($counts[$record['status']])) {
                    $counts[$record['status']]++;
                }
            }
        ?>
            <tr>
                <td><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></td>
                <td><?php echo $counts['present']; ?></td>
                <td><?php echo $counts['absent']; ?></td>
                <td><?php echo $counts['late']; ?></td>
                <td><?php echo $counts['half-day']; ?></td>
                <td><?php echo $counts['on-leave']; ?></td>
                <td>
                    <a href="details.php?employee_id=<?php echo $employee['employee_id']; ?>&month=<?php echo $month; ?>&year=<?php echo $year; ?>" class="btn">
                        View Details
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../../includes/footer.php'; ?>
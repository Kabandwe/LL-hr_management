<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

require_login();

$page_title = "Leave Management";
include '../../includes/header.php';

// Get all leave records
$stmt = $pdo->query("SELECT l.*, e.first_name, e.last_name 
                     FROM leave_records l
                     JOIN employees e ON l.employee_id = e.employee_id
                     ORDER BY l.start_date DESC");
$leave_records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<h2>Leave Management</h2>

<div class="actions">
    <a href="apply.php" class="btn">Apply for Leave</a>
</div>

<table>
    <thead>
        <tr>
            <th>Employee</th>
            <th>Leave Type</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Days</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($leave_records as $leave): ?>
            <tr>
                <td><?php echo htmlspecialchars($leave['first_name'] . ' ' . $leave['last_name']); ?></td>
                <td><?php echo ucfirst($leave['leave_type']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($leave['start_date'])); ?></td>
                <td><?php echo date('d/m/Y', strtotime($leave['end_date'])); ?></td>
                <td><?php echo $leave['leave_days']; ?></td>
                <td><?php echo ucfirst($leave['status']); ?></td>
                <td class="actions">
                    <a href="view.php?id=<?php echo $leave['leave_id']; ?>" class="btn">View</a>
                    <?php if ($leave['status'] == 'pending'): ?>
                        <a href="approve.php?id=<?php echo $leave['leave_id']; ?>" class="btn">Approve</a>
                        <a href="reject.php?id=<?php echo $leave['leave_id']; ?>" class="btn">Reject</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<h3>Employees with More Than Half Leave Remaining</h3>
<?php
$employees_with_leave = get_employees_with_remaining_leave();
if (!empty($employees_with_leave)): ?>
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Total Leave</th>
                <th>Taken</th>
                <th>Remaining</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($employees_with_leave as $employee): ?>
                <tr>
                    <td><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></td>
                    <td><?php echo $employee['total_leave_days']; ?></td>
                    <td><?php echo $employee['taken_leave_days']; ?></td>
                    <td><?php echo $employee['remaining_leave_days']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p>No employees with more than half their leave remaining.</p>
<?php endif; ?>

<?php include '../../includes/footer.php'; ?>
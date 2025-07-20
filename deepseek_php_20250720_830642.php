<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';
require_once 'includes/functions.php';

require_login();

$page_title = "Dashboard";
include 'includes/header.php';

// Get counts for dashboard
$total_employees = $pdo->query("SELECT COUNT(*) FROM employees")->fetchColumn();
$total_contract_workers = $pdo->query("SELECT COUNT(*) FROM contract_workers")->fetchColumn();
$employees_with_leave = get_employees_with_remaining_leave();
?>

<div class="dashboard">
    <div class="stats">
        <div class="stat-card">
            <h3>Total Employees</h3>
            <p><?php echo $total_employees; ?></p>
        </div>
        <div class="stat-card">
            <h3>Contract Workers</h3>
            <p><?php echo $total_contract_workers; ?></p>
        </div>
        <div class="stat-card">
            <h3>Employees with >50% Leave</h3>
            <p><?php echo count($employees_with_leave); ?></p>
        </div>
    </div>

    <div class="dashboard-sections">
        <section class="recent-activity">
            <h2>Recent Activity</h2>
            <!-- Placeholder for recent activity -->
            <p>No recent activity to display.</p>
        </section>

        <section class="leave-alerts">
            <h2>Leave Status Alerts</h2>
            <?php if (!empty($employees_with_leave)): ?>
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
                <p>No leave alerts to display.</p>
            <?php endif; ?>
        </section>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
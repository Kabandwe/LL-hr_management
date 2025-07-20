<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

require_login();

$page_title = "Employee List";
include '../../includes/header.php';

$employees = get_all_employees();
?>

<h2>Employee Management</h2>

<div class="actions">
    <a href="add.php" class="btn">Add New Employee</a>
</div>

<table>
    <thead>
        <tr>
            <th>Employee ID</th>
            <th>Name</th>
            <th>National ID</th>
            <th>Hire Date</th>
            <th>Location</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($employees as $employee): ?>
            <tr>
                <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                <td><?php echo htmlspecialchars($employee['first_name'] . ' ' . $employee['last_name']); ?></td>
                <td><?php echo htmlspecialchars($employee['national_id']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($employee['hire_date'])); ?></td>
                <td><?php echo htmlspecialchars($employee['location']); ?></td>
                <td class="actions">
                    <a href="view.php?id=<?php echo $employee['employee_id']; ?>" class="btn">View</a>
                    <a href="edit.php?id=<?php echo $employee['employee_id']; ?>" class="btn">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../../includes/footer.php'; ?>
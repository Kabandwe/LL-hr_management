<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

require_login();

$page_title = "Contract Workers";
include '../../includes/header.php';

$contract_workers = get_contract_workers();
?>

<h2>Contract Workers Management</h2>

<div class="actions">
    <a href="add.php" class="btn">Add New Contract Worker</a>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>National ID</th>
            <th>Category</th>
            <th>Location</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contract_workers as $worker): ?>
            <tr>
                <td><?php echo htmlspecialchars($worker['first_name'] . ' ' . $worker['last_name']); ?></td>
                <td><?php echo htmlspecialchars($worker['national_id']); ?></td>
                <td><?php echo htmlspecialchars($worker['category']); ?></td>
                <td><?php echo htmlspecialchars($worker['location']); ?></td>
                <td><?php echo date('d/m/Y', strtotime($worker['start_date'])); ?></td>
                <td><?php echo $worker['end_date'] ? date('d/m/Y', strtotime($worker['end_date'])) : 'Ongoing'; ?></td>
                <td class="actions">
                    <a href="view.php?id=<?php echo $worker['contract_id']; ?>" class="btn">View</a>
                    <a href="edit.php?id=<?php echo $worker['contract_id']; ?>" class="btn">Edit</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include '../../includes/footer.php'; ?>
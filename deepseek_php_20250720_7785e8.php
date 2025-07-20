<?php
require_once '../../includes/config.php';
require_once '../../includes/auth.php';
require_once '../../includes/functions.php';

require_login();

$page_title = "Add New Employee";
include '../../includes/header.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $employee_id = trim($_POST['employee_id']);
    $national_id = trim($_POST['national_id']);
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $hire_date = trim($_POST['hire_date']);
    $location = trim($_POST['location']);
    
    try {
        $stmt = $pdo->prepare("INSERT INTO employees (employee_id, national_id, first_name, last_name, email, phone, hire_date, location) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$employee_id, $national_id, $first_name, $last_name, $email, $phone, $hire_date, $location]);
        
        // Also create a leave allocation for the current year
        $current_year = date('Y');
        $stmt = $pdo->prepare("INSERT INTO leave_allocations (employee_id, year, total_leave_days, taken_leave_days) 
                              VALUES (?, ?, 21, 0)");
        $stmt->execute([$employee_id, $current_year]);
        
        $_SESSION['success_message'] = "Employee added successfully!";
        header("Location: list.php");
        exit();
    } catch (PDOException $e) {
        $error = "Error adding employee: " . $e->getMessage();
    }
}
?>

<h2>Add New Employee</h2>

<?php if (isset($error)): ?>
    <div class="alert alert-danger"><?php echo $error; ?></div>
<?php endif; ?>

<form method="POST" action="add.php">
    <div class="form-group">
        <label for="employee_id">Employee ID:</label>
        <input type="text" id="employee_id" name="employee_id" required>
    </div>
    <div class="form-group">
        <label for="national_id">National ID:</label>
        <input type="text" id="national_id" name="national_id" required>
    </div>
    <div class="form-group">
        <label for="first_name">First Name:</label>
        <input type="text" id="first_name" name="first_name" required>
    </div>
    <div class="form-group">
        <label for="last_name">Last Name:</label>
        <input type="text" id="last_name" name="last_name" required>
    </div>
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">
    </div>
    <div class="form-group">
        <label for="phone">Phone:</label>
        <input type="text" id="phone" name="phone">
    </div>
    <div class="form-group">
        <label for="hire_date">Hire Date:</label>
        <input type="date" id="hire_date" name="hire_date" required>
    </div>
    <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location">
    </div>
    <button type="submit" class="btn">Add Employee</button>
    <a href="list.php" class="btn">Cancel</a>
</form>

<?php include '../../includes/footer.php'; ?>
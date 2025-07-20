<?php
require_once 'config.php';

// Function to get employee details
function get_employee($employee_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT * FROM employees WHERE employee_id = ?");
    $stmt->execute([$employee_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to get all employees
function get_all_employees() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM employees ORDER BY last_name, first_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get contract workers
function get_contract_workers() {
    global $pdo;
    
    $stmt = $pdo->query("SELECT * FROM contract_workers ORDER BY last_name, first_name");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get leave balance
function get_leave_balance($employee_id, $year = null) {
    global $pdo;
    
    if ($year === null) {
        $year = date('Y');
    }
    
    $stmt = $pdo->prepare("SELECT * FROM leave_allocations WHERE employee_id = ? AND year = ?");
    $stmt->execute([$employee_id, $year]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// Function to get attendance for an employee in a month
function get_monthly_attendance($employee_id, $month, $year) {
    global $pdo;
    
    $start_date = "$year-$month-01";
    $end_date = "$year-$month-31";
    
    $stmt = $pdo->prepare("SELECT * FROM attendance 
                          WHERE employee_id = ? AND date BETWEEN ? AND ?
                          ORDER BY date");
    $stmt->execute([$employee_id, $start_date, $end_date]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get employees who haven't taken half their leave days
function get_employees_with_remaining_leave($year = null) {
    global $pdo;
    
    if ($year === null) {
        $year = date('Y');
    }
    
    $stmt = $pdo->prepare("SELECT e.*, la.total_leave_days, la.taken_leave_days, la.remaining_leave_days
                          FROM employees e
                          JOIN leave_allocations la ON e.employee_id = la.employee_id
                          WHERE la.year = ? AND la.remaining_leave_days > (la.total_leave_days / 2)
                          ORDER BY la.remaining_leave_days DESC");
    $stmt->execute([$year]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Function to get employee medical scheme
function get_employee_medical_scheme($employee_id) {
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT ems.*, ms.scheme_name, ms.scheme_type
                          FROM employee_medical_schemes ems
                          JOIN medical_schemes ms ON ems.scheme_id = ms.scheme_id
                          WHERE ems.employee_id = ? AND ems.is_active = 1");
    $stmt->execute([$employee_id]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
?>
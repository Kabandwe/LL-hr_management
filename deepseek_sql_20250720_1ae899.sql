-- Create database
CREATE DATABASE IF NOT EXISTS hr_management;
USE hr_management;

-- Employees table
CREATE TABLE employees (
    employee_id VARCHAR(20) PRIMARY KEY,
    national_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    hire_date DATE NOT NULL,
    is_contract_worker BOOLEAN DEFAULT FALSE,
    location VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Contract workers table
CREATE TABLE contract_workers (
    contract_id INT AUTO_INCREMENT PRIMARY KEY,
    national_id VARCHAR(20) UNIQUE NOT NULL,
    first_name VARCHAR(50) NOT NULL,
    last_name VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    phone VARCHAR(20),
    category VARCHAR(50) NOT NULL,
    location VARCHAR(100) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (national_id) REFERENCES employees(national_id) ON DELETE CASCADE
);

-- Leave allocation table
CREATE TABLE leave_allocations (
    allocation_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) NOT NULL,
    year YEAR NOT NULL,
    total_leave_days INT NOT NULL DEFAULT 21,
    taken_leave_days INT NOT NULL DEFAULT 0,
    remaining_leave_days INT GENERATED ALWAYS AS (total_leave_days - taken_leave_days) STORED,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE,
    UNIQUE KEY (employee_id, year)
);

-- Leave records table
CREATE TABLE leave_records (
    leave_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    leave_days INT NOT NULL,
    leave_type ENUM('annual', 'sick', 'maternity', 'paternity', 'unpaid') NOT NULL,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE
);

-- Attendance table
CREATE TABLE attendance (
    attendance_id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) NOT NULL,
    date DATE NOT NULL,
    check_in TIME,
    check_out TIME,
    status ENUM('present', 'absent', 'late', 'half-day', 'on-leave') NOT NULL,
    notes TEXT,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE,
    UNIQUE KEY (employee_id, date)
);

-- Medical schemes table
CREATE TABLE medical_schemes (
    scheme_id INT AUTO_INCREMENT PRIMARY KEY,
    scheme_name VARCHAR(100) NOT NULL,
    scheme_type ENUM('basic', 'premium', 'family', 'individual') NOT NULL,
    description TEXT
);

-- Employee medical schemes
CREATE TABLE employee_medical_schemes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_id VARCHAR(20) NOT NULL,
    scheme_id INT NOT NULL,
    start_date DATE NOT NULL,
    end_date DATE,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (employee_id) REFERENCES employees(employee_id) ON DELETE CASCADE,
    FOREIGN KEY (scheme_id) REFERENCES medical_schemes(scheme_id) ON DELETE CASCADE
);

-- Insert some default medical schemes
INSERT INTO medical_schemes (scheme_name, scheme_type, description) VALUES
('Company Basic', 'basic', 'Basic health coverage for employees'),
('Company Premium', 'premium', 'Premium health coverage with dental and optical'),
('Family Plan', 'family', 'Health coverage for employee and family'),
('Individual Plus', 'individual', 'Enhanced individual coverage');
<?php
include("../db.php");

function fetch_employees($conn, $email) {
    $stmt = $conn->prepare("SELECT name,designation, phone, department FROM employees WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

// Function to fetch employee information by email
function get_employee_info($conn, $email) {
    
    $sql = "SELECT * FROM employees WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return null;
    }

    $stmt->close();
    
}


// Function to fetch employee's daily attendance for the last 30 days
function get_employee_monthly_attendance($conn , $employee_id) {
    
    $sql = "SELECT date, status, check_in_time, check_out_time 
            FROM attendance 
            WHERE employee_id = ? AND date >= CURDATE() - INTERVAL 7 DAY 
            ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendance_records = [];
    while ($row = $result->fetch_assoc()) {
        $attendance_records[] = $row;
    }

    $stmt->close();
    

    return $attendance_records;
}
// Function to fetch employee attendance summary
function get_employee_attendance_summary( $conn ,$employee_id) {
   
    $sql = "SELECT status, COUNT(*) as count FROM attendance WHERE employee_id = ? GROUP BY status";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendance_summary = [
        "Present" => 0,
        "Absent" => 0,
        "Late" => 0,
        "On Leave" => 0
    ];

    while ($row = $result->fetch_assoc()) {
        $attendance_summary[$row['status']] = $row['count'];
    }

    $stmt->close();
    

    return $attendance_summary;
}

// Function to fetch employee attendance summary from the start of the current month
function get_employee_attendance_monthly_summary($conn, $employee_id) {
   
    // Get the first day of the current month
    $first_day_of_month = date('Y-m-01'); // Format: 'YYYY-MM-01'
    
    $sql = "SELECT status, COUNT(*) as count 
            FROM attendance 
            WHERE employee_id = ? AND date >= ? 
            GROUP BY status";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $employee_id, $first_day_of_month);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendance_summary = [
        "Present" => 0,
        "Absent" => 0,
        "Late" => 0,
        "On Leave" => 0
    ];

    while ($row = $result->fetch_assoc()) {
        $attendance_summary[$row['status']] = $row['count'];
    }

    $stmt->close();

    return $attendance_summary;
}

// Function to fetch employee's daily attendance from the start date to the current date
function get_daily_attendance($conn,$employee_id) {
   
    $sql = "SELECT date, status, check_in_time, check_out_time 
            FROM attendance 
            WHERE employee_id = ? 
            ORDER BY date DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $attendance_records = [];
    while ($row = $result->fetch_assoc()) {
        $attendance_records[] = $row;
    }

    $stmt->close();

    return $attendance_records;
}

function create_attendence($conn,  $employee_id, $date, $status, $check_in_time, $check_out_time){
    $stmt= $conn->prepare("INSERT INTO attendance(`employee_id`, `date`,`status`,  `check_in_time`, `check_out_time`) VALUES(?,?,?,?,?)");
    $stmt->bind_param("issss", $employee_id, $date, $status, $check_in_time, $check_out_time);
    return $stmt->execute();
}



function login_employee($conn, $email, $password) {
    $stmt = $conn->prepare("SELECT `password` FROM employees WHERE `email` = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $hashed_password="";
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            return true;
        }
    }

    return false;
}

?>
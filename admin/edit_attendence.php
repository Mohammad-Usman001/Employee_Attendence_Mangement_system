<?php
session_start();
require_once("functions.php");

// Validate attendance_id from URL
if (!isset($_GET['attendance_id']) || !is_numeric($_GET['attendance_id'])) {
    $_SESSION['error'] = "Invalid attendance ID";
    header("Location: attendence.php");
    exit();
}

$attendance_id = (int)$_GET['attendance_id'];

// Fetch attendance record
$attendance_data = edit_attendance($conn, $attendance_id);

if (!$attendance_data) {
    $_SESSION['error'] = "Attendance record not found";
    header("Location: attendence.php");
    exit();
}

// If form is submitted with updates
if (isset($_POST['update_attendance'])) {
    // Add your update logic here
    $status = $_POST['status'];
    $check_in = $_POST['check_in_time'];
    $check_out = $_POST['check_out_time'];
    
    // Update the record
    $update_success = update_attendence($conn, $attendance_id, $status, $check_in, $check_out);
    
    if ($update_success) {
        $_SESSION['success'] = "Attendance updated successfully";
        header("Location: attendance.php");
        exit();
    } else {
        $_SESSION['error'] = "Failed to update attendance";
    }
}

?>


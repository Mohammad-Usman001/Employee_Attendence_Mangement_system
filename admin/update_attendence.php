<?php
include("functions.php");

if(isset($_POST['update'])){
    $status=$_POST['status'];
    $check_in_time=$_POST['check_in_time'];
    $check_out_time=$_POST['check_out_time'];
    $attendance_id=$_POST['attendance_id'];

    if(update_attendence($conn, $status, $check_in_time, $check_out_time,$attendance_id)){
        header("Location: attendence.php");
        exit();
    }
}else{
    echo " error: not updated.";
}




?>
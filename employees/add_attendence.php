<?php
include("functions.php");

if(isset($_POST['submit'])){
    $employee_id=$_POST['employee_id'];
    $date=$_POST['date'];
    $status=$_POST['status'];
    $check_in_time=$_POST['check_in_time'];
    $check_out_time=$_POST['check_out_time'];


    if(create_attendence($conn,  $employee_id, $date, $status, $check_in_time, $check_out_time)){
        header('Location: dashboard.php');
        exit();
    }else{
        echo"failed to add attendence ";
    }
}



?>


<?php
include ("functions.php");



if(isset($_POST['update'])){
    $name= $_POST['name'];
    $designation= $_POST['designation'];
    $email= $_POST['email'];
    $phone= $_POST['phone'];
    $department= $_POST['department'];
    $join_date= $_POST['join_date'];
    $employee_id = $_POST['employee_id'];

    if(update_employees($conn,$name, $designation, $email, $phone, $department, $join_date, $employee_id)){
        header("Location: manage_employees.php");
        exit();
    }else {
        echo "Error updating the record.". $conn->error;
    }
}



?>
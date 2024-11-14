<?php

include("functions.php");

// if(isset($_GET['attendance_id'])){
//     $attendance_id=$_GET['attendance_id'];

//     if(delete_attendence($conn, $attendance_id)){
//         header('Location: index.php');
//         exit();
//     }
// }

if(isset($_GET['employee_id'])){
    $employee_id= $_GET['employee_id'];

    if(delete_employees($conn, $employee_id)){
        header('Location: manage_employees.php');
        exit();
    }else{
        echo " failed to delete:";
    }
    
}
else {
    echo "No employee ID provided.";
}
?>
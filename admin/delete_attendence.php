<?php
include("functions.php");

if(isset($_GET['attendance_id'])){
    $attendance_id=$_GET['attendance_id'];

    if(delete_attendence($conn, $attendance_id)){
        header('Location: index.php');
        exit();
    }
}else{
    echo "error";
}


?>
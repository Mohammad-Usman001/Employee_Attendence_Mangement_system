<?php
include("functions.php");


if(isset($_POST["submit"])){
    $name= $_POST['name'];
    $designation=$_POST['designation'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $phone=$_POST['phone'];
    $department=$_POST['department'];
    $join_date=$_POST['join_date'];

    if (create_employees($conn, $name, $designation, $email,$password, $phone, $department, $join_date)){
        header("Location: index.php");
    }else{
        echo "failed to create";
    }

}



?>
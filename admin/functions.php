<?php
include("../db.php");

function create_employees($conn, $name, $designation, $email,$password, $phone, $department, $join_date)
{
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO employees (`name`, `designation`, `email`, `password`,`phone`, `department`, `join_date`) VALUES (?, ?, ?,?, ?, ?, ?)");
    $stmt->bind_param("sssssss", $name, $designation, $email,$hashed_password, $phone, $department, $join_date);
    return $stmt->execute();
}

function fetch_employees($conn)
{
    $stmt = $conn->query("SELECT * FROM employees ORDER BY join_date ASC");
    return $stmt->fetch_all(MYSQLI_ASSOC);
}

function delete_employees($conn, $employee_id){
    $stmt=$conn->prepare("DELETE FROM employees WHERE employee_id =?");
    $stmt->bind_param("i", $employee_id);
    return $stmt->execute();
}

function get_employees($conn,$employee_id){
    $stmt=$conn->prepare("SELECT * FROM employees WHERE employee_id=?");
    $stmt->bind_param("i", $employee_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

function update_employees($conn,$name, $designation, $email, $phone, $department, $join_date, $employee_id ){
    $stmt = $conn->prepare("UPDATE employees SET name=?, designation=?,email=?, phone=?, department=?, join_date=? WHERE employee_id=? ");
    $stmt->bind_param('ssssssi', $name, $designation, $email, $phone, $department, $join_date, $employee_id);
    return $stmt->execute();
}

function update_attendence($conn, $status, $check_in_time, $check_out_time,$attendance_id){
    $stmt=$conn->prepare("UPDATE attendance SET status=?,check_in_time=?, check_out_time=? where attendance_id=?");
    $stmt->bind_param('sssi',$status, $check_in_time, $check_out_time,$attendance_id );
    return $stmt->execute();
}

function delete_attendence($conn, $attendance_id){
    $stmt=$conn->prepare("DELETE FROM attendance WHERE attendance_id=?");
    $stmt->bind_param("i", $attendance_id);
    return $stmt->execute();
}

function edit_attendance($conn, $attendance_id) {
    $stmt = $conn->prepare("SELECT status, check_in_time, check_out_time 
                           FROM attendance 
                           WHERE attendance_id = ?");
    $stmt->bind_param("i", $attendance_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}
function fetch_attendence($conn,$date = null)
{
    $dateFilter = $date ? $date : date('Y-m-d');

    $sql = "SELECT 
            attendance.attendance_id,
            employees.employee_id,
            employees.name,
            employees.designation,
            employees.department,
            attendance.date,
            attendance.status,
            attendance.check_in_time,
            attendance.check_out_time
        FROM 
            attendance
        INNER JOIN 
            employees ON attendance.employee_id = employees.employee_id
        WHERE 
            attendance.date = ?
        ORDER BY 
        attendance.check_in_time";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $dateFilter);
$stmt->execute();
$result = $stmt->get_result();

return $result;

}
function get_total_entries($conn)
{
    $sql = "SELECT COUNT(*) AS total_entries FROM employees";
    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['total_entries'];
    } else {
        return 0; // Return 0 if the query fails
    }
}

function get_today_present_count($conn)
{
    $sql = "SELECT COUNT(*) AS present_count 
            FROM attendance 
            WHERE date = CURDATE() AND status = 'present'"; // Assuming 'present' is the status for attendance

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['present_count'];
    } else {
        return 0; // Return 0 if the query fails
    }
}
function get_today_absent_count($conn)
{
    $sql = "SELECT COUNT(*) AS absent_count 
            FROM attendance 
            WHERE date = CURDATE() AND status = 'Absent'"; // Assuming 'present' is the status for attendance

    $result = $conn->query($sql);

    if ($result && $row = $result->fetch_assoc()) {
        return $row['absent_count'];
    } else {
        return 0; // Return 0 if the query fails
    }
}


function register_user($conn, $username, $password){
    try{
        $password_hashed= password_hash($password, PASSWORD_BCRYPT);
        $stmt=$conn->prepare("INSERT INTO admin (`username`, `password`) VALUES (?,?)");
        $stmt->bind_param("ss",$username, $password_hashed );
        return $stmt->execute();

    }
    catch(mysqli_sql_exception $e){
        
        if($e->getCode() == 1062){
            echo " username already exist:";
        }else{
            echo " An error occured:" . $e->getMessage();
        }
        return false;
    }
    
}

function authenticate_user($conn, $username, $password){

    $stmt=$conn->prepare("SELECT admin_id, password FROM admin where username=?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result=$stmt->get_result();

    if($result->num_rows>0){
        $user = $result->fetch_assoc();
        $id= $user['admin_id'];
        $hashed_password =$user['password'];

        if(password_verify($password, $hashed_password)){
            $stmt->close();
            return ['admin_id'=> $id, 'username'=> $username];
        }
        $stmt->close();
        return false;
    }
}
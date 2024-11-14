<?php

session_start();

if (!isset($_SESSION["employee_logged_in"]) || $_SESSION["employee_logged_in"] !== true) {
    header("Location: login.php");
    exit;
}

include("functions.php");

$employee_email = $_SESSION["email"];
$employee_info = get_employee_info($conn, $employee_email);

if ($employee_info) {
    $employee_id = $employee_info['employee_id']; // Assuming 'id' is the employee's unique ID in the database
    $attendance_summary = get_employee_attendance_summary($conn, $employee_id);
    $monthly_attendance = get_employee_monthly_attendance($conn, $employee_id);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
</head>

<body>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container d-flex">
  <h2 class="mb-4 ">Employee Dashboard</h2>
    
      <div class="navbar-nav">
      <a href="logout.php" class="btn btn-warning btn-lg ms-auto" style="--bs-btn-padding: .25rem;">Log Out</a>
      
      </div>
    
  </div>
</nav>
    <div class="container-fluid mt-4">
        <!-- Page Title -->
        <div class="container">
            
            <!-- Dashboard Overview Section -->
            <div class="row">
                <!-- Attendance Card -->
                <div class="col-6">
                    <div class="col-md-6 mb-3">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Attendence</h5>
                                <p>Check your attendence record</p>
                                <a href="attendence_list.php" class="btn btn-light btn-sm">View Details</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-6 d-flex ">
                    <div class="col-md-6 mb-3  ms-auto">
                        <div class="card bg-secondary text-white  align-item-centre">
                            <div class="card-body ">
                                <h5 class="card-title">Mark Attendence</h5>
                                <button class="btn btn-primary mb-3 " data-bs-toggle="modal" data-bs-target="#leaveRequestModal">Add Attendence</button>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Information Section -->
            <div class="row">
                <div class="col-6">
                    <?php if ($employee_info): ?>
                        <div class="card mb-3 bg-success">
                            <div class="card-body">
                                <h5 class="card-title text-black fs-22 fw-bold">Employee Information</h5>
                                <p class="text-white"><strong class="text-warning">Name:</strong> <?php echo $employee_info['name']; ?></p>
                                <p class="text-white"><strong class="text-warning">Email:</strong> <?php echo $employee_info['email']; ?></p>
                                <p class="text-white"><strong class="text-warning">Position:</strong> <?php echo $employee_info['designation']; ?></p>
                                <p class="text-white"><strong class="text-warning">Department:</strong> <?php echo $employee_info['department']; ?></p>
                            </div>
                        </div>
                </div>
                <!-- Attendance Summary Section -->
                <div class="col-6">
                    <div class="card mb-3 bg-primary">
                        <div class="card-body">
                            <h5 class="card-title text-black fs-22 fw-bold">Attendence Summary</h5>
                            <p class="text-white"><strong class="text-warning">Present Days:</strong> <?php echo $attendance_summary['Present']; ?></p>
                            <p class="text-white"><strong class="text-warning">Absent Days:</strong> <?php echo $attendance_summary['Absent']; ?></p>
                            <p class="text-white"><strong class="text-warning">Late Days:</strong> <?php echo $attendance_summary['Late']; ?></p>
                            <p class="text-white"><strong class="text-warning">On Leave Days:</strong> <?php echo $attendance_summary['On Leave']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Weekly Attendance Records Section -->

            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Last 7 Days Attendence</h5>
                    <div class="table-responsive">
                        <table class="table table-bordered" id="attendanceTable">
                            <thead class="table-dark">
                                <tr>
                                    <th>Date</th>
                                    <th>Status</th>
                                    <th>Check-In Time</th>
                                    <th>Check-Out Time</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($monthly_attendance)): ?>
                                    <?php foreach ($monthly_attendance as $attendance): ?>
                                        <tr>
                                            <td><?php echo $attendance['date']; ?></td>
                                            <td><?php echo $attendance['status']; ?></td>
                                            <td><?php echo $attendance['check_in_time'] ? $attendance['check_in_time'] : '-'; ?></td>
                                            <td><?php echo $attendance['check_out_time'] ? $attendance['check_out_time'] : '-'; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="4" class="text-center">No attendence records found for the past 7 days.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        <?php else: ?>
            <p class="text-danger">Employee information not found.</p>
        <?php endif; ?>
        <div class="modal fade" id="leaveRequestModal" tabindex="-1" aria-labelledby="leaveRequestModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form action="add_attendence.php" method="post">
                        <div class="modal-header">
                            <h5 class="modal-title" id="AttendenceRequestModalLabel">Attendence</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">

                            <div class="mb-3">
                                <label for="employee_id" class="form-label">Employee id</label>
                                <input type="number" id="employee_id" class="form-control" value="<?php echo $employee_info['employee_id']; ?>" name="employee_id" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="endDate" class="form-label">Date</label>
                                <input type="date" id="endDate" class="form-control" name="date" required>
                            </div>
                            <div class="mb-3">
                                <label for="leaveType" class="form-label" name="status">Status</label>
                                <select id="leaveType" class="form-control" name="status" required>
                                    <option value="Present" name="Present">Present</option>
                                    <option value="Absent" name="Absent">Absent</option>
                                    <option value="Late" name="Late">Late</option>
                                    <option value="on Leave" name="On Leave">On Leave</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="Check_in_time" class="form-label">Check in Time</label>
                                <input type="time" id="Check_in_time" class="form-control" name="check_in_time">
                            </div>
                            <div class="mb-3">
                                <label for="Check_Out_time" class="form-label">Check Out Time</label>
                                <input type="time" id="Check_Out_time" class="form-control" name="check_out_time">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" name="submit" class="btn btn-primary">Add Attendence</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        </div>

        <!-- Required Scripts -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        <!-- DataTables Scripts -->
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.min.js"></script>

        <script>
            $(document).ready(function() {
                $('#attendanceTable').DataTable({});
            });
        </script>
</body>

</html>
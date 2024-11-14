<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Attendance List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">
</head>
<body>
    <?php
    session_start();

    if (!isset($_SESSION["employee_logged_in"]) || $_SESSION["employee_logged_in"] !== true) {
        header("Location: login.php");
        exit;
    }

    include("functions.php");

    $employee_email = $_SESSION["email"];
    $employee_info = get_employee_info($conn,$employee_email);

    if ($employee_info) {
        $employee_id = $employee_info['employee_id'];
        $attendance_records = get_daily_attendance($conn,$employee_id);
    }
    ?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container d-flex">
  <h2 class="mb-4 ">Employee Dashboard</h2>
    
      <div class="navbar-nav">
      <a href="logout.php" class="btn btn-warning btn-lg ms-auto" style="--bs-btn-padding: .25rem;">Log Out</a>
      
      </div>
    
  </div>
</nav>
<div class="container mt-5">
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Daily Attendance (From Start Date to Current Date)</h5>
            <table id="attendanceTable" class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Check-In Time</th>
                        <th>Check-Out Time</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($attendance_records)): ?>
                        <?php foreach ($attendance_records as $record): ?>
                            <tr>
                                <td><?php echo $record['date']; ?></td>
                                <td><?php echo $record['status']; ?></td>
                                <td><?php echo $record['check_in_time'] ? $record['check_in_time'] : 'N/A'; ?></td>
                                <td><?php echo $record['check_out_time'] ? $record['check_out_time'] : 'N/A'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No attendance records found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <a href="dashboard.php" class="btn btn-primary mb-3 btn-lg">Back</a>
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
            $('#attendanceTable').DataTable({
            });
        });
    </script>
</body>
</html>
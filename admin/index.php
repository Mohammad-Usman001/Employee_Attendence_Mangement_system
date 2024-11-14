<?php
session_start();

if (!isset($_SESSION["admin_logged_in"]) || $_SESSION["admin_logged_in"] !== true) {
    header("Location: admin_login.php");
    exit;
}
include("header.php");
include("layout.php");
include("navbar.php");
include("dashboard.php");
include("footer.php");
include("functions.php");

$date = isset($_GET['date']) ? $_GET['date'] : null;
$result = fetch_attendence($conn, $date);
$totalEntries = get_total_entries($conn);
$todayPresentCount = get_today_present_count($conn);
$todayabsentcount = get_today_absent_count($conn);
?>




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <!-- Sidebar -->

    <!-- Page Content -->
    <div id="page-content-wrapper">
        <!-- Navbar -->
        <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <h3 class="ms-3">Admin Dashboard</h3>
        </nav> -->
        
        <!-- Dashboard Content -->
        <div class="container-fluid ">
        <h2 class="mb-4">Admin Dashboard</h2>
            <div class="row">
                <!-- Cards for Summary Stats -->
                <div class="col-md-3">
                    <div class="card text-white bg-primary mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Total Employees</h5>
                            <p class="card-text"><?php echo htmlspecialchars($totalEntries); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-success mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Present Today</h5>
                            <p class="card-text"><?php echo htmlspecialchars($todayPresentCount); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-danger mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Absent Today</h5>
                            <p class="card-text"><?php echo htmlspecialchars($todayabsentcount); ?></p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card text-white bg-warning mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Pending Leave Requests</h5>
                            <p class="card-text">3</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Employee Table -->
            <h4 class="mt-4">Employee Attendance Summary</h4>
            <?php if ($result && $result->num_rows > 0): ?>
                <table class="table table-hover mt-3">
                    <thead>
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Date</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($employee = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                                <td><?php echo htmlspecialchars($employee['name']); ?></td>
                                <td><?php echo htmlspecialchars($employee['designation']); ?></td>
                                <td><?php echo htmlspecialchars($employee['date']); ?></td>
                                <td ><?php echo htmlspecialchars($employee['status']); ?></td>
                                <td>
                                    <!-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">Edit</button> -->

                                    <a href="delete_attendence.php?attendance_id=<?php echo $employee['attendance_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this post?')">Delete</a>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        <!-- Add more rows as needed -->
                    </tbody>
                </table>
            <?php else: ?>
                <p>No attendance records found for today.</p>
            <?php endif; ?>
        </div>
    </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Toggle Script for Sidebar -->
    <script>
        document.getElementById("menu-toggle").onclick = function() {
            document.getElementById("wrapper").classList.toggle("toggled");
        };
    </script>

    <!-- Custom CSS for Sidebar Layout -->
    <style>
        #wrapper {
            display: flex;
            width: 100%;
        }

        #sidebar-wrapper {
            width: 250px;
        }

        #page-content-wrapper {
            width: 100%;
        }

        .toggled #sidebar-wrapper {
            width: 0;
        }
    </style>
</body>

</html>
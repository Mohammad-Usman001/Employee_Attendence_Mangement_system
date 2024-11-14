<?php
session_start();
include("header.php");
include("layout.php");
include("navbar.php");
include("dashboard.php");
include("footer.php");
include("functions.php");

// Get date from GET parameters
$date = isset($_GET['date']) ? $_GET['date'] : null;
$result = fetch_attendence($conn, $date);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Management - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-4">
        <h2 class="mb-4">Manage Attendance</h2>

        <!-- Filter by Date -->
        <div class="d-flex justify-content-between mb-3">
            <div>
                <label for="filterDate" class="form-label">Select Date:</label>
                <input type="date" id="filterDate" class="form-control mt-2">
            </div>
            <div>
                <button class="btn btn-primary mt-4" onclick="filterAttendance()">Filter</button>
            </div>
        </div>

        <!-- Success/Error Messages -->
        <?php if(isset($_SESSION['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['success']; 
                    unset($_SESSION['success']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php 
                    echo $_SESSION['error']; 
                    unset($_SESSION['error']);
                ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <!-- Attendance Table -->
        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Employee ID</th>
                            <th>Name</th>
                            <th>Designation</th>
                            <th>Department</th>
                            <th>Date</th>
                            <th>Status</th>
                            <th>Check-In</th>
                            <th>Check-Out</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($employee = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($employee['employee_id']); ?></td>
                                <td><?php echo htmlspecialchars($employee['name']); ?></td>
                                <td><?php echo htmlspecialchars($employee['designation']); ?></td>
                                <td><?php echo htmlspecialchars($employee['department']); ?></td>
                                <td><?php echo htmlspecialchars($employee['date']); ?></td>
                                <td><?php echo htmlspecialchars($employee['status']); ?></td>
                                <td><?php echo htmlspecialchars($employee['check_in_time']); ?></td>
                                <td><?php echo htmlspecialchars($employee['check_out_time']); ?></td>
                                <td>
                                    <button type="button" 
                                            class="btn btn-warning btn-sm" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editAttendanceModal"
                                            onclick="loadAttendanceData('<?php echo $employee['attendance_id']; ?>', 
                                                                      '<?php echo $employee['status']; ?>', 
                                                                      '<?php echo $employee['check_in_time']; ?>', 
                                                                      '<?php echo $employee['check_out_time']; ?>')">
                                        Edit
                                    </button>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p>No attendance records found for the selected date.</p>
        <?php endif; ?>
    </div>

    <!-- Edit Attendance Modal -->
    <div class="modal fade" id="editAttendanceModal" tabindex="-1" aria-labelledby="editAttendanceModalLabel" aria-hidden="true" data-bs-backdrop="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="editAttendanceForm" action="update_attendence.php" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editAttendanceModalLabel">Edit Attendance</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="attendance_id" id="editAttendanceId">
                        <div class="mb-3">
                            <label for="editStatus" class="form-label">Status</label>
                            <select class="form-control" id="editStatus" name="status" required>
                                <option value="Present">Present</option>
                                <option value="Absent">Absent</option>
                                <option value="Late">Late</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editCheckIn" class="form-label">Check-In Time</label>
                            <input type="datetime-local" class="form-control" id="editCheckIn" name="check_in_time">
                        </div>
                        <div class="mb-3">
                            <label for="editCheckOut" class="form-label">Check-Out Time</label>
                            <input type="datetime-local" class="form-control" id="editCheckOut" name="check_out_time">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="update" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function filterAttendance() {
            const filterDate = document.getElementById("filterDate").value;
            if (filterDate) {
                window.location.href = `attendence.php?date=${filterDate}`;
            } else {
                alert("Please select a date to filter.");
            }
        }

        function loadAttendanceData(attendanceId, status, checkIn, checkOut) {
    // Helper function to format MySQL datetime or time-only to HTML5 datetime-local
    const formatDateTime = (mysqlDateTime) => {
        if (!mysqlDateTime) return '';
        
        // Check if input is time-only (e.g., hh:mm:ss)
        if (/^\d{2}:\d{2}(:\d{2})?$/.test(mysqlDateTime)) {
            // Use a default date if only time is provided
            const defaultDate = new Date().toISOString().split('T')[0];
            const timePart = mysqlDateTime.slice(0, 5); // Use "hh:mm" format
            return `${defaultDate}T${timePart}`;
        }

        // For full datetime, split date and time parts
        const [datePart, timePart] = mysqlDateTime.split(' ');
        const formattedTime = timePart ? timePart.slice(0, 5) : "00:00";
        
        return `${datePart}T${formattedTime}`;
    };

    // Set values in modal
    document.getElementById('editAttendanceId').value = attendanceId;
    document.getElementById('editStatus').value = status;
    document.getElementById('editCheckIn').value = formatDateTime(checkIn);
    document.getElementById('editCheckOut').value = formatDateTime(checkOut);
}


    </script>
</body>
</html>

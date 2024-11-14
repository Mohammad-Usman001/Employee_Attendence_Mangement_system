<?php

include("header.php");
include("layout.php");
include("navbar.php");
include("dashboard.php");
include("footer.php");


?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request Management - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-4">
        <!-- Page Title -->
        <h2 class="mb-4">Manage Leave Requests</h2>

        <!-- Filter by Date Range -->
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="startDate" class="form-label">Start Date:</label>
                <input type="date" id="startDate" class="form-control">
            </div>
            <div class="col-md-4">
                <label for="endDate" class="form-label">End Date:</label>
                <input type="date" id="endDate" class="form-control">
            </div>
            <div class="col-md-4 d-flex align-items-end">
                <button class="btn btn-primary w-100" onclick="filterRequests()">Filter</button>
            </div>
        </div>

        <!-- Leave Requests Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Request ID</th>
                        <th>Employee Name</th>
                        <th>Designation</th>
                        <th>Department</th>
                        <th>Leave Type</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Jane Smith</td>
                        <td>Project Manager</td>
                        <td>Marketing</td>
                        <td>Annual Leave</td>
                        <td>2024-10-15</td>
                        <td>2024-10-20</td>
                        <td>Pending</td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="approveRequest()">Approve</button>
                            <button class="btn btn-danger btn-sm" onclick="rejectRequest()">Reject</button>
                            <button class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewDetailsModal">View</button>
                        </td>
                    </tr>
                    <!-- Repeat <tr> for each leave request -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- View Details Modal -->
    <div class="modal fade" id="viewDetailsModal" tabindex="-1" aria-labelledby="viewDetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="viewDetailsModalLabel">Leave Request Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p><strong>Employee Name:</strong> Jane Smith</p>
                    <p><strong>Designation:</strong> Project Manager</p>
                    <p><strong>Department:</strong> Marketing</p>
                    <p><strong>Leave Type:</strong> Annual Leave</p>
                    <p><strong>Leave Dates:</strong> 2024-10-15 to 2024-10-20</p>
                    <p><strong>Reason:</strong> Family trip</p>
                    <p><strong>Status:</strong> Pending</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Custom JavaScript -->
    <script>
        // Placeholder function for filtering requests by date range
        function filterRequests() {
            const startDate = document.getElementById("startDate").value;
            const endDate = document.getElementById("endDate").value;
            alert("Filtering leave requests from " + startDate + " to " + endDate);
            // Implement backend filter logic here
        }

        // Placeholder function for approving a leave request
        function approveRequest() {
            alert("Leave request approved.");
            // Implement backend approval logic here
        }

        // Placeholder function for rejecting a leave request
        function rejectRequest() {
            alert("Leave request rejected.");
            // Implement backend rejection logic here
        }
    </script>
</body>
</html>

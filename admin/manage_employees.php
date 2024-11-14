<?php
session_start();
include("header.php");
include("layout.php");
include("navbar.php");
include("dashboard.php");
include("footer.php");
include("functions.php");
// include("edit_employees.php");

$employees= fetch_employees($conn);
$employee_id = "";

$employeess= get_employees($conn,$employee_id);



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Employees - Admin Dashboard</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container-fluid mt-0">
        <!-- Page Title -->
        <h2 class="mb-4">Manage Employees</h2>

        <!-- Add Employee Button -->
        <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addEmployeeModal">Add New Employee</button>

        <!-- Employees Table -->
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Email</th>
                        
                        <th>Phone</th>
                        <th>Department</th>
                        <th>Join Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($employees as $employe):?>
                    <tr>
                        <td><?php echo htmlspecialchars($employe['employee_id']); ?></td>
                        <td><?php echo htmlspecialchars($employe['name']); ?></td>
                        <td><?php echo htmlspecialchars($employe['designation']); ?></td>
                        <td><?php echo htmlspecialchars($employe['email']); ?></td>
                        <td><?php echo htmlspecialchars($employe['phone']); ?></td>
                        <td><?php echo htmlspecialchars($employe['department']); ?></td>
                        <td><?php echo htmlspecialchars($employe['join_date']); ?></td>
                        <td>
                        <a href="edit_employees.php?employee_id=<?php echo $employe['employee_id']; ?>" class="btn btn-warning btn-sm" >Edit</a>
                            <!-- <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editEmployeeModal">Edit</button> -->
                            <a href="delete_employees.php?employee_id=<?php echo $employe['employee_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this employee info?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                    <!-- Repeat <tr> for each employee -->
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add Employee Modal -->
    <div class="modal fade" id="addEmployeeModal" tabindex="-1" aria-labelledby="addEmployeeModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="create_employees.php" method="post">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addEmployeeModalLabel">Add New Employee</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name"  name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation"  name="designation"  required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="passsword" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Department</label>
                            <input type="text" class="form-control" id="department"  name="department" required>
                        </div>
                        <div class="mb-3">
                            <label for="join_date" class="form-label">join date</label>
                            <input type="date" class="form-control" id="join_date"  name="join_date" required>
                        </div>
                       
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="submit" class="btn btn-primary">Add Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
                
    <!-- Edit Employee Modal -->
    <!--  -->
 
    
    <!-- Bootstrap and jQuery Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

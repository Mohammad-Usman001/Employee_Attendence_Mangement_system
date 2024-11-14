<?php

include("functions.php");


if (isset($_GET['employee_id'])) {
    $employee_id = $_GET['employee_id'];
    $employeess = get_employees($conn, $employee_id);
}

if (!$employeess) {
    header("Location: manage_employees.php");
    exit();
}

?>

<div class="modal fade" id="editEmployeeModal" tabindex="-1" aria-labelledby="editEmployeeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="update_employees.php" method="post">

                <div class="modal-header">
                    <h5 class="modal-title" id="editEmployeeModalLabel">Edit Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                <input type="hidden" name="employee_id" value="<?php echo $employeess['employee_id']; ?>">

                    <div class="mb-3">
                        <label for="editName" class="form-label">Name</label>
                        <input type="text" class="form-control" id="editName" name="name" value="<?php echo $employeess['name']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDesignation" class="form-label">Designation</label>
                        <input type="text" class="form-control" id="editDesignation" name="designation" value="<?php echo $employeess['designation']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" value="<?php echo $employeess['email']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="editPhone" name="phone" value="<?php echo $employeess['phone']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editDepartment" class="form-label">Department</label>
                        <input type="text" class="form-control" id="editDepartment" name="department" value="<?php echo $employeess['department']; ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPhone" class="form-label">Join Date</label>
                        <input type="tel" class="form-control" id="editPhone" name="join_date" value="<?php echo $employeess['join_date']; ?>" required>
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
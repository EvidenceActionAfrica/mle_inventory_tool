<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 80px;
        }
        .table-container {
            width: 70%;
        }
        .form-container {
            width: 30%;
        }
        .card {
            padding: 15px;
        }
    </style>
</head>
<body>

<div class="container">
    <h4>Manage Users</h4>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($_GET['success']) ?> </div>
    <?php endif; ?>

    <div class="row">
        <!-- Users Table -->
        <div class="col-md-8 table-container">
            <table>
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Position</th>
                        <th>Role</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $user): ?>
                            <tr>
                                <td><?= htmlspecialchars($user->email) ?></td>
                                <td><?= htmlspecialchars($user->department_name) ?></td>
                                <td><?= htmlspecialchars($user->position_name) ?></td>
                                <td><?= htmlspecialchars($user->role) ?></td>
                                <td>
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" 
                                        onclick="editUser('<?php echo $user->id; ?>', 
                                                        '<?php echo $user->email; ?>', 
                                                        '<?php echo $user->department; ?>', 
                                                        '<?php echo $user->position; ?>', 
                                                        '<?php echo $user->role; ?>')">
                                        Edit
                                    </button>


                                    <!-- Delete Button -->
                                    <a href="<?= URL ?>users/delete?delete=<?= $user->id ?>" 
                                    class="btn btn-danger btn-sm" 
                                    onclick="return confirm('Are you sure you want to delete this user?');">
                                    Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="5">No users found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add User Form -->
        <div class="col-md-4 form-container">
            <div class="card">
                <h5 class="text-center">Add User</h5>
                <form method="POST" action="<?= URL ?>users/add">
                    <div class="mb-3">
                        <label>Email:</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Department:</label>
                        <select name="department" class="form-control">
                            <option value="">Select Department</option>
                            <?php foreach ($departments as $dept): ?>
                                <option value="<?= $dept->id ?>"><?= htmlspecialchars($dept->department_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Position:</label>
                        <select name="position" class="form-control">
                            <option value="">Select Position</option>
                            <?php foreach ($positions as $pos): ?>
                                <option value="<?= $pos->id ?>"><?= htmlspecialchars($pos->position_name) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Role:</label>
                        <select name="role" class="form-control">
                            <option value="">Select Role</option>
                            <?php foreach ($roles as $role): ?>
                                <option value="<?= $role ?>"><?= ucfirst($role) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Add User</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-form" method="POST" action="<?= URL ?>users/edit">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label>Email:</label>
                            <input type="email" name="email" id="edit_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Department:</label>
                            <select name="department" id="edit_department" class="form-control">
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept->id ?>"><?= htmlspecialchars($dept->department_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Position:</label>
                            <select name="position" id="edit_position" class="form-control">
                                <option value="">Select Position</option>
                                <?php foreach ($positions as $pos): ?>
                                    <option value="<?= $pos->id ?>"><?= htmlspecialchars($pos->position_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Role:</label>
                            <select name="role" id="edit_role" class="form-control">
                                <option value="">Select Role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role ?>"><?= ucfirst($role) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function editUser(id, email, departmentId, positionId, role) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_email').value = email;

    let deptDropdown = document.getElementById('edit_department');
    let posDropdown = document.getElementById('edit_position');
    let roleDropdown = document.getElementById('edit_role');

    // Ensure department and position are set correctly
    if (departmentId) {
        deptDropdown.value = departmentId;
    } else {
        deptDropdown.selectedIndex = 0;
    }

    if (positionId) {
        posDropdown.value = positionId;
    } else {
        posDropdown.selectedIndex = 0;
    }

    if (role) {
        roleDropdown.value = role;
    } else {
        roleDropdown.selectedIndex = 0;
    }

    var myModal = new bootstrap.Modal(document.getElementById('editModal'));
    myModal.show();
}
</script>

</body>
</html>

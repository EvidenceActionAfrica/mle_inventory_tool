<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<body>

<div>
    <h2>Users</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"> <?= htmlspecialchars($_GET['success']) ?> </div>
    <?php endif; ?>
    <div class="top-bar" style="display: flex; justify-content: flex-end; padding: 10px;">
            <button class="add-btn " onclick="openUserModal()">Add User</button>
        </div>
    <div class="row">
        <!-- Users Table -->
        <div class="col-md-12">
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
                                        onclick="openUserModal('<?php echo $user->id; ?>', 
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
    </div>

    <!-- Add/Edit User Modal -->
    <div id="userModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="user-form" method="POST">
                    <div class="modal-header">
                        <h5 class="modal-title" id="userModalTitle">Add User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="user_id">
                        <input type="hidden" name="mode" id="user_mode" value="add">

                        <div class="mb-3">
                            <label>Email:</label>
                            <input type="email" name="email" id="user_email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Department:</label>
                            <select name="department" id="user_department" class="form-control">
                                <option value="">Select Department</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept->id ?>"><?= htmlspecialchars($dept->department_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Position:</label>
                            <select name="position" id="user_position" class="form-control">
                                <option value="">Select Position</option>
                                <?php foreach ($positions as $pos): ?>
                                    <option value="<?= $pos->id ?>"><?= htmlspecialchars($pos->position_name) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Role:</label>
                            <select name="role" id="user_role" class="form-control">
                                <option value="">Select Role</option>
                                <?php foreach ($roles as $role): ?>
                                    <option value="<?= $role ?>"><?= ucfirst($role) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="submitButton">Add User</button>
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
function openUserModal(id = '', email = '', departmentId = '', positionId = '', role = '') {
    let modalTitle = document.getElementById('userModalTitle');
    let submitButton = document.getElementById('submitButton');
    let form = document.getElementById('user-form');

    if (id) {
        // Edit Mode
        modalTitle.innerText = 'Edit User';
        submitButton.innerText = 'Update User';
        form.action = "<?= URL ?>users/edit";  // Set form action for editing
        document.getElementById('user_mode').value = 'edit';

        document.getElementById('user_id').value = id;
        document.getElementById('user_email').value = email;
        document.getElementById('user_department').value = departmentId;
        document.getElementById('user_position').value = positionId;
        document.getElementById('user_role').value = role;
    } else {
        // Add Mode
        modalTitle.innerText = 'Add User';
        submitButton.innerText = 'Add User';
        form.action = "<?= URL ?>users/add";  // Set form action for adding
        document.getElementById('user_mode').value = 'add';

        document.getElementById('user_id').value = '';
        document.getElementById('user_email').value = '';
        document.getElementById('user_department').selectedIndex = 0;
        document.getElementById('user_position').selectedIndex = 0;
        document.getElementById('user_role').selectedIndex = 0;
    }

    var myModal = new bootstrap.Modal(document.getElementById('userModal'));
    myModal.show();
}
</script>

</body>

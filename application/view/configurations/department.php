<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<div>
    <h2>Departments</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <div class="top-bar" style="display: flex; justify-content: flex-end; padding: 10px;">
        <button class="add-btn " onclick="openAddModal()">Add Department</button>
    </div>

    <div class="row">
        <!-- Table takes up full width -->
        <div class="col-md-12 table-container">
            <table >
                <thead>
                    <tr>
                        <th>Department Name</th>
                        <th>Parent Department</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($departments)): ?>
                    <?php foreach ($departments as $department): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($department['department_name']); ?></td>
                            <td><?php echo htmlspecialchars($department['parent_name'] ?? 'None'); ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm"
                                    onclick="openEditModal(
                                        <?= $department['id'] ?>, 
                                        '<?= htmlspecialchars($department['department_name'], ENT_QUOTES) ?>',
                                        <?= $department['parent_id'] ?? 'null' ?>
                                    )">
                                    Edit
                                </button>
                                  
                                <!-- Delete Button -->
                                <a href="<?= URL ?>department/delete?delete=<?= $department['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this department?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No departments found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>            
        </div>
    </div>

    <!-- Edit/Add Modal -->
    <div id="editModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="department-form" method="POST" action="<?= URL ?>department/add">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Add Department</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="department_id">
                        <div class="mb-3">
                            <label>Department Name:</label>
                            <input type="text" name="department_name" id="department_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Parent Department:</label>
                            <select name="parent_id" id="parent_id" class="form-control">
                                <option value="">None</option>
                                <?php foreach ($departments as $dept): ?>
                                    <option value="<?= $dept['id'] ?>"><?= htmlspecialchars($dept['department_name']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="saveButton">Add Department</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Open Add Department Modal
    window.openAddModal = function () {
        // Reset the form for adding a new department
        document.getElementById('department-form').action = '<?= URL ?>department/add';
        document.getElementById('modalTitle').textContent = 'Add Department';
        document.getElementById('department_id').value = ''; // Ensure the id field is empty
        document.getElementById('department_name').value = ''; // Clear department name
        document.getElementById('parent_id').value = ''; // Reset parent department

        var editModal = new bootstrap.Modal(document.getElementById('editModal'), {
            keyboard: false
        });
        editModal.show();
    }

    // Open Edit Department Modal
    window.openEditModal = function (id, name, parentId) {
        // Populate the form with the current department data
        document.getElementById('department-form').action = '<?= URL ?>department/edit';
        document.getElementById('modalTitle').textContent = 'Edit Department';
        document.getElementById('department_id').value = id;
        document.getElementById('department_name').value = name;
        document.getElementById('parent_id').value = parentId;

        var editModal = new bootstrap.Modal(document.getElementById('editModal'), {
            keyboard: false
        });
        editModal.show();
    }
});
</script>

</body>

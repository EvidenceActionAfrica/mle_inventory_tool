<!-- Styles -->
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Department Management</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Departments</li>
    </ol>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-building me-1"></i></span>
            <button class="btn add-btn btn-sm" onclick="openAddModal()">Add Department</button>
        </div>

        <div class="card-body">
            <table id="departmentsTable">
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
                            <td><?= htmlspecialchars($department['department_name']); ?></td>
                            <td><?= htmlspecialchars($department['parent_name'] ?? 'None'); ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                    onclick="openEditModal(
                                        <?= $department['id'] ?>, 
                                        '<?= htmlspecialchars($department['department_name'], ENT_QUOTES) ?>',
                                        <?= $department['parent_id'] ?? 'null' ?>
                                    )">
                                    Edit
                                </button>
                                <a href="<?= URL ?>department/delete?delete=<?= $department['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this department?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">No departments found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

<!-- Modal -->
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
                        <label for="department_name" class="form-label">Department Name:</label>
                        <input type="text" name="department_name" id="department_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="parent_id" class="form-label">Parent Department:</label>
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

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // Open Add Department Modal
    window.openAddModal = function () {
        document.getElementById('department-form').action = '<?= URL ?>department/add';
        document.getElementById('modalTitle').textContent = 'Add Department';
        document.getElementById('department_id').value = '';
        document.getElementById('department_name').value = '';
        document.getElementById('parent_id').value = '';

        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    // Open Edit Department Modal
    window.openEditModal = function (id, name, parentId) {
        document.getElementById('department-form').action = '<?= URL ?>department/edit';
        document.getElementById('modalTitle').textContent = 'Edit Department';
        document.getElementById('department_id').value = id;
        document.getElementById('department_name').value = name;
        document.getElementById('parent_id').value = parentId;

        new bootstrap.Modal(document.getElementById('editModal')).show();
    }

    // Initialize DataTable
    const table = document.getElementById('departmentsTable');
    if (table) {
        new simpleDatatables.DataTable(table);
    }
});
</script>

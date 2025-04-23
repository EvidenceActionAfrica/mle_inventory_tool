<!-- Styles -->
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Position Management</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Admin</li>
        <li class="breadcrumb-item">Positions</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            This is a list of the positions in the organisations.
        </div>
    </div>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i></span>
            <button class="btn add-btn btn-sm" onclick="openModal('add')">Add Position</button>
        </div>

        <div class="card-body table-responsive">
            <table id="positionsTable">
                <thead>
                    <tr>
                        <th>Position Name</th>
                        <th>Hierarchy Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($positions)): ?>
                    <?php foreach ($positions as $position): ?>
                        <tr>
                            <td><?= htmlspecialchars($position['position_name']); ?></td>
                            <td><?= htmlspecialchars($position['hierarchy_level']); ?></td>
                            <td>
                                <button class="btn btn-sm btn-outline-primary"
                                    onclick="openModal('edit', <?= $position['id'] ?>, '<?= htmlspecialchars($position['position_name']) ?>', <?= $position['hierarchy_level'] ?>)">
                                    Edit
                                </button>
                                <a href="<?= URL ?>positions/delete?delete=<?= $position['id'] ?>" 
                                   class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Are you sure you want to delete this position?');">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="3">No positions found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

<!-- Modal -->
<div id="positionModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="position-form" method="POST">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add Position</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="position_id">
                    <div class="mb-3">
                        <label for="position_name" class="form-label">Position Name:</label>
                        <input type="text" name="position_name" id="position_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="position_level" class="form-label">Hierarchy Level:</label>
                        <input type="number" name="hierarchy_level" id="position_level" class="form-control" required min="1">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="modal-submit" class="btn btn-primary">Add Position</button>
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
function openModal(action, id = '', name = '', level = '') {
    const modalTitle = document.getElementById('modal-title');
    const form = document.getElementById('position-form');
    const submitBtn = document.getElementById('modal-submit');

    if (action === 'add') {
        modalTitle.innerText = 'Add Position';
        form.action = "<?= URL ?>positions/add";
        submitBtn.innerText = 'Add Position';
        document.getElementById('position_id').value = '';
        document.getElementById('position_name').value = '';
        document.getElementById('position_level').value = '';
    } else {
        modalTitle.innerText = 'Edit Position';
        form.action = "<?= URL ?>positions/edit";
        submitBtn.innerText = 'Update Position';
        document.getElementById('position_id').value = id;
        document.getElementById('position_name').value = name;
        document.getElementById('position_level').value = level;
    }

    const modal = new bootstrap.Modal(document.getElementById('positionModal'));
    modal.show();
}

window.addEventListener('DOMContentLoaded', () => {
    const datatable = document.getElementById('positionsTable');
    if (datatable) {
        new simpleDatatables.DataTable(datatable);
    }
});
</script>

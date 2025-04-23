<!-- Styles -->
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Office Management</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Admin</li>
        <li class="breadcrumb-item">Offices</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            A list of offices and the locations they are based.
        </div>
    </div>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-building me-1"></i> </span>
            <button class="btn add-btn btn-sm" onclick="openAddModal()">Add Office</button>
        </div>

        <div class="card-body table-responsive">
            <table id="officesTable">
                <thead>
                    <tr>
                        <th>Office Name</th>
                        <th>Location</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($offices as $office): ?>
                    <tr>
                        <td><?= htmlspecialchars($office['office_name']) ?></td>
                        <td><?= htmlspecialchars($office['location_name']) ?></td>
                        <td>
                            <button class="btn btn-sm btn-outline-primary"
                                    onclick="editOffice(
                                        <?= $office['id'] ?>,
                                        '<?= htmlspecialchars($office['office_name'], ENT_QUOTES) ?>',
                                        <?= $office['location_id'] ?>
                                    )">
                                Edit
                            </button>
                            <a href="<?= URL ?>office/delete?delete=<?= $office['id'] ?>" 
                            class="btn btn-sm btn-outline-danger" 
                               onclick="return confirm('Are you sure you want to delete this office?')">
                               Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

<!-- Modal -->
<div id="officeModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="office-form" method="POST" action="<?= URL ?>office/add">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add Office</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="modal_id">

                    <div class="mb-3">
                        <label class="form-label">Location:</label>
                        <select name="location_id" id="modal_location_id" class="form-control" required>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['location_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Office Name:</label>
                        <input type="text" name="office_name" id="modal_office_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-primary" id="modal-submit-button">Add Office</button>
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
    // Initialize DataTable
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById('officesTable');
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });

    function openAddModal() {
        document.getElementById('office-form').action = "<?= URL ?>office/add";
        document.getElementById('modal-title').textContent = "Add Office";
        document.getElementById('modal-submit-button').textContent = "Add Office";
        document.getElementById('modal_id').value = '';
        document.getElementById('modal_office_name').value = '';
        document.getElementById('modal_location_id').value = '';

        new bootstrap.Modal(document.getElementById('officeModal')).show();
    }

    function editOffice(id, officeName, locationId) {
        document.getElementById('office-form').action = "<?= URL ?>office/edit";
        document.getElementById('modal-title').textContent = "Edit Office";
        document.getElementById('modal-submit-button').textContent = "Update Office";
        document.getElementById('modal_id').value = id;
        document.getElementById('modal_office_name').value = officeName;
        document.getElementById('modal_location_id').value = locationId;

        new bootstrap.Modal(document.getElementById('officeModal')).show();
    }
</script>

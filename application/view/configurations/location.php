<!-- Styles -->
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Location Management</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Locations</li>
    </ol>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-map-marker-alt me-1"></i> </span>
            <button class="btn add-btn btn-sm" onclick="openLocationModal()">Add Location</button>
        </div>

        <div class="card-body">
            <table id="locationsTable">
                <thead>
                    <tr>
                        <th>Location Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($locations)): ?>
                    <?php foreach ($locations as $location): ?>
                        <tr>
                            <td><?= htmlspecialchars($location['location_name']) ?></td>
                            <td>
                                <button class="btn btn-warning btn-sm"
                                        onclick="openLocationModal(
                                            <?= $location['id'] ?>,
                                            '<?= htmlspecialchars($location['location_name'], ENT_QUOTES) ?>'
                                        )">
                                    Edit
                                </button>
                                <a href="<?= URL ?>location/delete?delete=<?= $location['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this location?')">
                                   Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="2">No locations found.</td></tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

<!-- Modal -->
<div id="locationModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="location-form" method="POST" action="<?= URL ?>location/add">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-title">Add Location</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="modal_id">
                    <div class="mb-3">
                        <label class="form-label">Location Name:</label>
                        <input type="text" name="location_name" id="modal_name" class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-primary" id="modal-submit-button">Add Location</button>
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
        const table = document.getElementById('locationsTable');
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });

    function openLocationModal(id = '', name = '') {
        if (id) {
            document.getElementById('location-form').action = "<?= URL ?>location/edit";
            document.getElementById('modal-title').textContent = "Edit Location";
            document.getElementById('modal-submit-button').textContent = "Update Location";
            document.getElementById('modal_id').value = id;
            document.getElementById('modal_name').value = name;
        } else {
            document.getElementById('location-form').action = "<?= URL ?>location/add";
            document.getElementById('modal-title').textContent = "Add Location";
            document.getElementById('modal-submit-button').textContent = "Add Location";
            document.getElementById('modal_id').value = '';
            document.getElementById('modal_name').value = '';
        }

        new bootstrap.Modal(document.getElementById('locationModal')).show();
    }
</script>

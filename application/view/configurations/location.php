<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<body>

<div>
    <h2>Locations</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <div class="top-bar" style="display: flex; justify-content: flex-end; padding: 10px;">
        <button class="add-btn " onclick="openModal()">Add Location</button>
    </div>
    <div class="row">
        <!-- Table -->
        <div class="col-md-12">
            <table >
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
                        <td><?php echo htmlspecialchars($location['location_name']); ?></td>
                        <td>
                            <!-- Edit Button -->
                            <button class="btn btn-warning btn-sm" onclick="openModal(<?= $location['id'] ?>, '<?= htmlspecialchars($location['location_name']) ?>')">Edit</button>

                            <!-- Delete Button -->
                            <a href="<?= URL ?>location/delete?delete=<?= $location['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this location?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="2">No locations found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Modal -->
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
                            <label>Location Name:</label>
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

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function openModal(id = '', name = '') {
    if (id) {
        // Edit mode
        document.getElementById('location-form').action = "<?= URL ?>location/edit";
        document.getElementById('modal-title').textContent = "Edit Location";
        document.getElementById('modal-submit-button').textContent = "Update Location";
        document.getElementById('modal_id').value = id;
        document.getElementById('modal_name').value = name;
    } else {
        // Add mode
        document.getElementById('location-form').action = "<?= URL ?>location/add";
        document.getElementById('modal-title').textContent = "Add Location";
        document.getElementById('modal-submit-button').textContent = "Add Location";
        document.getElementById('modal_id').value = ''; // Reset hidden ID
        document.getElementById('modal_name').value = ''; // Clear input field
    }

    var modal = new bootstrap.Modal(document.getElementById('locationModal'));
    modal.show();
}
</script>

</body>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Offices</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <h4>Manage Offices</h4>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8">
                <table >
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
                                    <!-- Edit Button -->
                                    <button class="btn btn-warning btn-sm" 
                                            onclick="editOffice(
                                                <?= $office['id'] ?>, 
                                                '<?= htmlspecialchars($office['office_name']) ?>', 
                                                <?= $office['location_id'] ?>
                                            )">
                                        Edit
                                    </button>
                                    <!-- Delete Button -->
                                    <a href="<?= URL ?>office/delete?delete=<?= $office['id'] ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Are you sure you want to delete this office?')">
                                        Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <h5>Add Office</h5>
                <form action="<?= URL ?>office/add" method="POST">
                    <div class="mb-3">
                        <label>Location:</label>
                        <select name="location_id" class="form-control" required>
                            <?php foreach ($locations as $location): ?>
                                <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['location_name']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Office Name:</label>
                        <input type="text" name="office_name" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Office</button>
                </form>
            </div>

            <!-- Edit Modal -->
            <div id="editModal" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="edit-form" method="POST" action="<?= URL ?>office/edit">
                            <div class="modal-header">
                                <h5 class="modal-title">Edit Office</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" name="id" id="edit_id">
                                
                                <div class="mb-3">
                                    <label>Location:</label>
                                    <select name="location_id" id="edit_location_id" class="form-control" required>
                                        <?php foreach ($locations as $location): ?>
                                            <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['location_name']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label>Office Name:</label>
                                    <input type="text" name="office_name" id="edit_office_name" class="form-control" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" name="update" class="btn btn-primary">Update</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function editOffice(id, officeName, locationId) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_office_name').value = officeName;
    document.getElementById('edit_location_id').value = locationId;

    // Ensure modal initializes properly
    const editModal = new bootstrap.Modal(document.getElementById('editModal'));
    editModal.show();
}
</script>
</body>
</html>

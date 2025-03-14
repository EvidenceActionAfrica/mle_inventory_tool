<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Locations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
    <style>
        .container {
            margin-top: 80px; /* To accommodate fixed navbar */
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
    <h4>Manage Locations</h4>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Table -->
        <div class="col-md-8 table-container">
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
                            <!-- Edit Button (opens modal or pre-fills form) -->
                            <button class="btn btn-warning btn-sm" onclick="editLocation(<?= $location['id'] ?>, '<?= htmlspecialchars($location['location_name']) ?>')">Edit</button>

                            <!-- Delete Button -->
                            <a href="<?= URL ?>location/delete?delete=<?= $location['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this location?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3">No locations found.</td>
                </tr>
            <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Form -->
        <div class="col-md-4 form-container">
            <div class="card">
                <h5 class="text-center">Add Location</h5>
                <form method="POST" action="<?= URL ?>location/add">
                    <div class="mb-3">
                        <label>Location Name:</label>
                        <input type="text" name="location_name" class="form-control" required>
                    </div>
                    <button type="submit" name="add" class="btn btn-primary w-100">Add Location</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
            <form id="edit-form" method="POST" action="<?= URL ?>location/edit">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Location</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label>Location Name:</label>
                            <input type="text" name="location_name" id="edit_name" class="form-control" required>
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

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
function editLocation(id, name) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    var myModal = new bootstrap.Modal(document.getElementById('editModal'));
    myModal.show();
}
</script>

</body>
</html>

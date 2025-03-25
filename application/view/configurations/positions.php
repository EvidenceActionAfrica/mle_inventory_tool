<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Positions</title>
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
    <h4>Manage Positions</h4>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>

    <div class="row">
        <!-- Table -->
        <div class="col-md-8 table-container">
            <table>
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
                            <td><?php echo htmlspecialchars($position['position_name']); ?></td>
                            <td><?php echo htmlspecialchars($position['hierarchy_level']); ?></td>
                            <td>
                                <!-- Edit Button (opens modal or pre-fills form) -->
                                <button class="btn btn-warning btn-sm" onclick="editPosition(<?= $position['id'] ?>, '<?= htmlspecialchars($position['position_name']) ?>', <?= $position['hierarchy_level'] ?>)">Edit</button>

                                <!-- Delete Button -->
                                <a href="<?= URL ?>positions/delete?delete=<?= $position['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this position?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="3">No positions found.</td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Form -->
        <div class="col-md-4 form-container">
            <div class="card">
                <h5 class="text-center">Add Position</h5>
                <form method="POST" action="<?= URL ?>positions/add">
                    <div class="mb-3">
                        <label>Position Name:</label>
                        <input type="text" name="position_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Hierarchy Level:</label>
                        <input type="number" name="hierarchy_level" class="form-control" required min="1">
                    </div>
                    <button type="submit" name="add" class="btn btn-primary w-100">Add Position</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div id="editModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="edit-form" method="POST" action="<?= URL ?>positions/edit">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Position</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="edit_id">
                        <div class="mb-3">
                            <label>Position Name:</label>
                            <input type="text" name="position_name" id="edit_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Hierarchy Level:</label>
                            <input type="number" name="hierarchy_level" id="edit_level" class="form-control" required min="1">
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
function editPosition(id, name, level) {
    document.getElementById('edit_id').value = id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_level').value = level;
    var myModal = new bootstrap.Modal(document.getElementById('editModal'));
    myModal.show();
}
</script>

</body>
</html>

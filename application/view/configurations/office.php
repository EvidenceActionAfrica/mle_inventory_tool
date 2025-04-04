<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<body>
    <div>
        <h2>Offices</h2>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
        <?php endif; ?>
        <div class="top-bar" style="display: flex; justify-content: flex-end; padding: 10px;">
            <button class="add-btn " onclick="openAddModal()">Add Office</button>
        </div>
        <div class="row">
            <div class="col-md-12">
                <table>
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
        </div>

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
                                <label>Location:</label>
                                <select name="location_id" id="modal_location_id" class="form-control" required>
                                    <?php foreach ($locations as $location): ?>
                                        <option value="<?= $location['id'] ?>"><?= htmlspecialchars($location['location_name']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label>Office Name:</label>
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

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        function openAddModal() {
            // Set the form for adding a new office
            document.getElementById('office-form').action = "<?= URL ?>office/add";
            document.getElementById('modal-title').textContent = "Add Office";
            document.getElementById('modal-submit-button').textContent = "Add Office";
            document.getElementById('modal_id').value = ''; // Clear hidden ID for new office
            document.getElementById('modal_office_name').value = ''; // Clear office name
            document.getElementById('modal_location_id').value = ''; // Reset location to default
            var officeModal = new bootstrap.Modal(document.getElementById('officeModal'));
            officeModal.show();
        }

        function editOffice(id, officeName, locationId) {
            // Set the form for editing an existing office
            document.getElementById('office-form').action = "<?= URL ?>office/edit";
            document.getElementById('modal-title').textContent = "Edit Office";
            document.getElementById('modal-submit-button').textContent = "Update Office";
            document.getElementById('modal_id').value = id;
            document.getElementById('modal_office_name').value = officeName;
            document.getElementById('modal_location_id').value = locationId;

            var officeModal = new bootstrap.Modal(document.getElementById('officeModal'));
            officeModal.show();
        }
    </script>

</body>

<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<body>

<div>
    <h2>Assets Catalogue</h2>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
    <?php endif; ?>
    <div class="top-bar" style="display: flex; justify-content: flex-end; padding: 10px;">
        <button class="add-btn " onclick="openModal()">Add Category</button>
    </div>
    <div class="row">
        <!-- Table -->
        <div class="col-md-12">
            <table>
                <thead>
                    <tr>
                        <th>Category Name</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= htmlspecialchars($category['category']) ?></td>
                            <td><?= htmlspecialchars($category['description']) ?></td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-warning btn-sm"
                                        onclick="openModal(<?= $category['id'] ?>, '<?= htmlspecialchars($category['category']) ?>', '<?= htmlspecialchars($category['description']) ?>')">
                                    Edit
                                </button>

                                <!-- Delete Button -->
                                <a href="<?= URL; ?>categories/delete?delete=<?= $category['id'] ?>" 
                                   class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this category?');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="categoryModal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="category-form" method="POST" action="<?= URL; ?>categories/add">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modal-title">Add Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" id="modal_id">
                        <div class="mb-3">
                            <label>Category Name:</label>
                            <input type="text" name="category_name" id="modal_category_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Description:</label>
                            <input type="text" name="description" id="modal_description" class="form-control" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" name="submit" class="btn btn-primary" id="modal-submit-button">Add Category</button>
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
function openModal(id = '', name = '', desc = '') {
    if (id) {
        // Edit mode
        document.getElementById('category-form').action = "<?= URL ?>categories/edit";
        document.getElementById('modal-title').textContent = "Edit Category";
        document.getElementById('modal-submit-button').textContent = "Update Category";
        document.getElementById('modal_id').value = id;
        document.getElementById('modal_category_name').value = name;
        document.getElementById('modal_description').value = desc;
    } else {
        // Add mode
        document.getElementById('category-form').action = "<?= URL ?>categories/add";
        document.getElementById('modal-title').textContent = "Add Category";
        document.getElementById('modal-submit-button').textContent = "Add Category";
        document.getElementById('modal_id').value = ''; // Reset hidden ID
        document.getElementById('modal_category_name').value = ''; // Clear input field
        document.getElementById('modal_description').value = ''; // Clear input field
    }

    var modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
}
</script>

</body>
</html>

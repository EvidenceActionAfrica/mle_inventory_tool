<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Assets Catalogue</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Configurations</li>
        <li class="breadcrumb-item">Categories</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            Here is the list of all available asset and their categories.
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i></span>
            <button class="add-btn" onclick="openModal()">Add Category</button>
        </div>

        <div class="card-body table-responsive">
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['success']) ?></div>
            <?php endif; ?>

            <table id="categoryTable">
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
                                <button class="btn btn-sm btn-outline-primary"
                                        onclick="openModal(<?= $category['id'] ?>, '<?= htmlspecialchars($category['category']) ?>', '<?= htmlspecialchars($category['description']) ?>')">
                                    Edit
                                </button>

                                <a href="<?= URL; ?>categories/delete?delete=<?= $category['id'] ?>" 
                                    class="btn btn-sm btn-outline-danger" 
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
</div>
</main>

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
                        <select name="category_name" id="modal_category_name" class="form-select" required>
                            <option value="">-- Select Category --</option>
                            <option value="Laptop">Laptop</option>
                            <option value="Smart Phone">Smart Phone</option>
                            <option value="Monitor">Monitor</option>
                            <option value="Mouse">Mouse</option>
                            <option value="Printer">Printer</option>
                            <option value="CPU">CPU</option>
                        </select>
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

<!-- Bootstrap & Simple DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
function openModal(id = '', name = '', desc = '') {
    const form = document.getElementById('category-form');
    const title = document.getElementById('modal-title');
    const button = document.getElementById('modal-submit-button');
    const idField = document.getElementById('modal_id');
    const categorySelect = document.getElementById('modal_category_name');
    const descriptionInput = document.getElementById('modal_description');

    if (id) {
        form.action = "<?= URL ?>categories/edit";
        title.textContent = "Edit Category";
        button.textContent = "Update Category";
        idField.value = id;
        descriptionInput.value = desc;

        // Set selected category
        Array.from(categorySelect.options).forEach(option => {
            option.selected = option.value === name;
        });
    } else {
        form.action = "<?= URL ?>categories/add";
        title.textContent = "Add Category";
        button.textContent = "Add Category";
        idField.value = '';
        categorySelect.value = '';
        descriptionInput.value = '';
    }

    const modal = new bootstrap.Modal(document.getElementById('categoryModal'));
    modal.show();
}

// Initialize Simple DataTables
window.addEventListener('DOMContentLoaded', () => {
    const datatable = document.getElementById('categoryTable');
    if (datatable) {
        new simpleDatatables.DataTable(datatable);
    }
});
</script>

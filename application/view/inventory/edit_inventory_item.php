<!-- CSS Links -->
<link href="<?= URL ?>css/style.css" rel="stylesheet">
<link href="<?= URL ?>css/tables.css" rel="stylesheet">
<!-- Inline Styles -->
<style>
    .card-centered {
        max-width: 650px;
        margin: 30px auto; /* Horizontally centered */
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .card-header {
        font-weight: 600;
        font-size: 1.2rem;
    }

    .form-label {
        font-weight: 500;
    }

    button[type="submit"] {
        width: 100%;
    }

    .breadcrumb {
        background: transparent;
        padding-left: 0;
    }

    .remove-item-btn {
        display: inline-block;
    }

    @media (max-width: 768px) {
        .card-centered {
            margin: 20px 10px;
        }
    }

    /* Simple Table Styling */
    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th, .table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .table th {
        background-color: #f4f4f4;
        font-weight: 600;
    }
</style>
<div class="container-fluid px-4">
    <h3 class="mt-4">Edit Inventory Item</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= URL ?>inventory">Inventory</a></li>
        <li class="breadcrumb-item">Edit Item</li>
    </ol>

    <!-- Alert Messages -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Edit Item Form in Card Style -->
    <div class="card mb-4 card-centered">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> 
        </div>
        <div class="card-body">
            <form action="<?= URL ?>inventory/edit/<?= htmlspecialchars($item['id']); ?>" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">

                <!-- Description dropdown -->
                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <select name="description" id="description" class="form-select" required onchange="populateCategory()">
                        <option value="">Select Description</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['description']) ?>" 
                                    data-category="<?= htmlspecialchars($category['category']) ?>" 
                                    data-category-id="<?= htmlspecialchars($category['id']) ?>"
                                    <?= $item['description'] == $category['description'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Category name (readonly) -->
                <div class="form-group mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <input type="text" id="category" class="form-control" value="<?= htmlspecialchars($descriptionToCategory[$item['description']] ?? '') ?>" readonly>
                    <input type="hidden" name="category_id" id="category_id" value="<?= htmlspecialchars($item['category_id']) ?>">
                </div>

                <!-- Serial Number -->
                <div class="form-group mb-3">
                    <label for="serial_number" class="form-label">Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number" class="form-control" value="<?= htmlspecialchars($item['serial_number']) ?>" required>
                </div>

                <!-- Tag Number -->
                <div class="form-group mb-3">
                    <label for="tag_number" class="form-label">Tag Number:</label>
                    <input type="text" id="tag_number" name="tag_number" class="form-control" value="<?= htmlspecialchars($item['tag_number']) ?>" required>
                </div>

                <!-- Acquisition Date -->
                <div class="form-group mb-3">
                    <label for="acquisition_date" class="form-label">Acquisition Date:</label>
                    <input type="date" id="acquisition_date" name="acquisition_date" class="form-control" value="<?= htmlspecialchars($item['acquisition_date']) ?>" required onchange="validateDate()">
                </div>

                <!-- Acquisition Cost -->
                <div class="form-group mb-3">
                    <label for="acquisition_cost" class="form-label">Acquisition Cost ($):</label>
                    <input type="number" id="acquisition_cost" name="acquisition_cost" class="form-control" step="0.01" value="<?= htmlspecialchars($item['acquisition_cost']) ?>" required>
                </div>

                <!-- Warranty Expiration Date -->
                <div class="form-group mb-3">
                    <label for="warranty_date" class="form-label">Warranty Expiration Date:</label>
                    <input type="date" id="warranty_date" name="warranty_date" class="form-control" value="<?= htmlspecialchars($item['warranty_date']) ?>" required>
                </div>

                <button type="submit" name="update" class="btn btn-success w-100">Update Item</button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        populateCategory();
    });

    function populateCategory() {
        let descriptionSelect = document.getElementById("description");
        let categoryField = document.getElementById("category");
        let categoryIdField = document.getElementById("category_id");

        let selectedOption = descriptionSelect.options[descriptionSelect.selectedIndex];
        categoryField.value = selectedOption.getAttribute("data-category"); // Sets category name
        categoryIdField.value = selectedOption.getAttribute("data-category-id"); // Sets category_id
    }

    function validateDate() {
        let acquisitionDate = document.getElementById("acquisition_date").value;
        let today = new Date().toISOString().split("T")[0];

        if (acquisitionDate > today) {
            alert("Acquisition date cannot be in the future!");
            document.getElementById("acquisition_date").value = "";
        }
    }
</script>
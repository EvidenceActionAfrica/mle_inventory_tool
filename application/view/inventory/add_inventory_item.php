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

<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Add New Inventory Item</h3>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= URL ?>inventory">Inventory</a></li>
            <li class="breadcrumb-item">Add New Item</li>
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

        <!-- Inventory Item Form in Card Style -->
        <div class="card mb-4 card-centered">
            <div class="card-header">
                <i class="fas fa-plus me-1"></i> 
            </div>
            <div class="card-body">
                <form action="<?= htmlspecialchars(URL . 'inventory/add') ?>" method="POST">
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <select name="category_id" id="description" class="form-select" required onchange="populateCategory()">
                            <option value="">Select Description</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['id']) ?>" 
                                        data-description="<?= htmlspecialchars($category['description']) ?>" 
                                        data-category="<?= htmlspecialchars($category['category']) ?>">
                                    <?= htmlspecialchars($category['description']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" id="description_text" name="description">

                    <div class="form-group mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <input type="text" name="category" id="category" class="form-control" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="serial_number" class="form-label">Serial Number:</label>
                        <input type="text" id="serial_number" name="serial_number" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tag_number" class="form-label">Tag Number:</label>
                        <input type="text" id="tag_number" name="tag_number" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="acquisition_date" class="form-label">Acquisition Date:</label>
                        <input type="date" id="acquisition_date" name="acquisition_date" class="form-control" required onchange="validateDate()">
                    </div>

                    <div class="form-group mb-3">
                        <label for="acquisition_cost" class="form-label">Acquisition Cost ($):</label>
                        <input type="number" id="acquisition_cost" name="acquisition_cost" class="form-control" step="0.01" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="warranty_date" class="form-label">Warranty Expiration Date:</label>
                        <input type="date" id="warranty_date" name="warranty_date" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success w-100">Submit</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    function populateCategory() {
        let descriptionSelect = document.getElementById("description");
        let selectedOption = descriptionSelect.options[descriptionSelect.selectedIndex];
        document.getElementById("description_text").value = selectedOption.getAttribute("data-description");
        document.getElementById("category").value = selectedOption.getAttribute("data-category");
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

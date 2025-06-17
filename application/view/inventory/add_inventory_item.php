<!-- CSS Links -->
<link href="<?= URL ?>css/style.css" rel="stylesheet">
<link href="<?= URL ?>css/tables.css" rel="stylesheet">

<style>
    .card-centered {
        max-width: 650px;
        margin: 30px auto;
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

    @media (max-width: 768px) {
        .card-centered {
            margin: 20px 10px;
        }
    }

    .table th, .table td {
        padding: 10px;
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

        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($_GET['success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <div class="card mb-4 card-centered">
            <div class="card-header"><i class="fas fa-plus me-1"></i> Add Item</div>
            <div class="card-body">
                <form action="<?= htmlspecialchars(URL . 'inventory/add') ?>" method="POST" id="addItemForm">
                    <div class="form-group mb-3">
                        <label for="description" class="form-label">Description:</label>
                        <select name="category_id" id="description" class="form-select" required onchange="populateCategory()">
                            <option value="">Select Description</option>
                            <?php foreach ($categories as $cat): ?>
                                <option value="<?= htmlspecialchars($cat['id']) ?>"
                                        data-description="<?= htmlspecialchars($cat['description']) ?>"
                                        data-category="<?= htmlspecialchars($cat['category']) ?>">
                                    <?= htmlspecialchars($cat['description']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <input type="hidden" name="description" id="description_text">

                    <div class="form-group mb-3">
                        <label for="category" class="form-label">Category:</label>
                        <input type="text" id="category" class="form-control" readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label for="serial_number" class="form-label">Serial Number:</label>
                        <input type="text" name="serial_number" class="form-control" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="tag_number" class="form-label">Tag Number:</label>
                        <input type="text" name="tag_number" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="acquisition_date" class="form-label">Acquisition Date:</label>
                        <input type="date" name="acquisition_date" class="form-control" required onchange="validateDate()">
                    </div>

                    <div class="form-group mb-3">
                        <label for="acquisition_cost" class="form-label">Acquisition Cost (Ksh):</label>
                        <input type="number" name="acquisition_cost" class="form-control" step="0.01" required>
                    </div>

                    <div class="form-group mb-3">
                        <label for="warranty_date" class="form-label">Warranty Expiration Date:</label>
                        <input type="date" name="warranty_date" class="form-control">
                    </div>

                    <div class="form-group mb-3">
                        <label for="custodian_id" class="form-label">Custodian:</label>
                        <select name="custodian_id" id="custodian_id" class="form-select" required onchange="setLocation()">
                            <option value="">Select Custodian</option>
                            <?php foreach ($custodians as $custodian): ?>
                                <option value="<?= htmlspecialchars($custodian->id) ?>"
                                        data-location-name="<?= htmlspecialchars($custodian->location_name) ?>"
                                        data-location-id="<?= htmlspecialchars($custodian->dutystation) ?>">
                                    <?= htmlspecialchars($custodian->name) ?> - <?= htmlspecialchars($custodian->position_name) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group mb-3">
                        <label for="location_display" class="form-label">Location:</label>
                        <input type="text" id="location_display" class="form-control" readonly>
                        <input type="hidden" id="location_id" name="location_id">
                    </div>

                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div>
        </div>
    </div>
</main>

<script>
    function populateCategory() {
        const descriptionSelect = document.getElementById('description');
        const selectedOption = descriptionSelect.options[descriptionSelect.selectedIndex];

        if (!selectedOption) return;

        const categoryName = selectedOption.getAttribute('data-category') || '';
        const descriptionText = selectedOption.getAttribute('data-description') || '';

        document.getElementById('category').value = categoryName;
        document.getElementById('description_text').value = descriptionText;
    }

    function setLocation() {
        const custodianSelect = document.getElementById('custodian_id');
        const selectedOption = custodianSelect.options[custodianSelect.selectedIndex];

        if (!selectedOption) {
            document.getElementById('location_display').value = '';
            document.getElementById('location_id').value = '';
            return;
        }

        const locationName = selectedOption.getAttribute('data-location-name') || '';
        const locationId = selectedOption.getAttribute('data-location-id') || '';

        document.getElementById('location_display').value = locationName;
        document.getElementById('location_id').value = locationId;
    }

    function validateDate() {
        const acquisitionDateInput = document.querySelector('input[name="acquisition_date"]');
        const today = new Date().toISOString().split('T')[0];

        if (acquisitionDateInput.value > today) {
            alert('Acquisition date cannot be in the future.');
            acquisitionDateInput.value = '';
        }
    }

    document.addEventListener('DOMContentLoaded', () => {
        populateCategory();
        setLocation();
    });
</script>

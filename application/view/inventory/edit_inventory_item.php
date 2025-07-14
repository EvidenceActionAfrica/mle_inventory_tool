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
</style>
<div class="container-fluid px-4">
    <h3 class="mt-4">Edit Inventory Item</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= URL ?>inventory">Inventory</a></li>
        <li class="breadcrumb-item" aria-current="page">Edit Item</li>
    </ol>

    <!-- Alert Messages -->
    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>
    
    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="card mb-4 card-centered">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> Edit Inventory Item
        </div>
        <div class="card-body">
            <form id="editForm" action="<?= URL ?>inventory/edit/<?= htmlspecialchars($item['id']); ?>" method="POST" novalidate>
                <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">

                <!-- Description Dropdown -->
                <div class="mb-3">
                    <label for="description" class="form-label">Description:</label>
                    <select name="description" id="description" class="form-select" required onchange="populateCategory()">
                        <option value="">Select Description</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['description']) ?>" 
                                data-category="<?= htmlspecialchars($category['category']) ?>"
                                data-category-id="<?= htmlspecialchars($category['id']) ?>" 
                                <?= ($item['category_id'] == $category['id']) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['description']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Category (readonly) -->
                <div class="mb-3">
                    <label for="category" class="form-label">Category:</label>
                    <input type="hidden" id="category_id" name="category_id" value="<?= htmlspecialchars($item['category_id']) ?>">
                    <input type="text" id="category" name="category" class="form-control" readonly
                        value="<?= htmlspecialchars($item['category'] ?? '') ?>">
                </div>

                <!-- Serial Number -->
                <div class="mb-3">
                    <label for="serial_number" class="form-label">Serial Number:</label>
                    <input type="text" id="serial_number" name="serial_number" class="form-control" value="<?= htmlspecialchars($item['serial_number']) ?>" required>
                </div>

                <!-- Tag Number -->
                <div class="mb-3">
                    <label for="tag_number" class="form-label">Tag Number:</label>
                    <input type="text" id="tag_number" name="tag_number" class="form-control" value="<?= htmlspecialchars($item['tag_number'] ?? '') ?>">
                </div>

                <!-- Acquisition Date -->
                <div class="mb-3">
                    <label for="acquisition_date" class="form-label">Acquisition Date:</label>
                    <input type="date" id="acquisition_date" name="acquisition_date" class="form-control" value="<?= htmlspecialchars($item['acquisition_date']) ?>" required onchange="validateDate()">
                </div>

                <!-- Acquisition Cost -->
                <div class="mb-3">
                    <label for="acquisition_cost" class="form-label">Acquisition Cost (Ksh):</label>
                    <input type="number" id="acquisition_cost" name="acquisition_cost" class="form-control" step="0.01" value="<?= htmlspecialchars($item['acquisition_cost']) ?>" required min="0">
                </div>

                <!-- Warranty Expiration Date -->
                <div class="mb-3">
                    <label for="warranty_date" class="form-label">Warranty Expiration Date:</label>
                    <input type="date" id="warranty_date" name="warranty_date" class="form-control" value="<?= htmlspecialchars($item['warranty_date'] ?? '') ?>">
                </div>

                <!-- Custodian -->
                <div class="mb-3">
                    <label for="custodian_id" class="form-label">Custodian:</label>
                    <select name="custodian_id" id="custodian_id" class="form-select" required onchange="setLocation()">
                        <option value="">Select Custodian</option>
                        <?php foreach ($custodians as $custodian): ?>
                            <option value="<?= htmlspecialchars($custodian->id) ?>"
                                data-location-name="<?= htmlspecialchars($custodian->dutystation) ?>"
                                data-location-id="<?= htmlspecialchars($custodian->dutystation) ?>"
                                <?= (isset($item['custodian']) && $item['custodian'] == $custodian->id) ? 'selected' : '' ?>>
                                <?= htmlspecialchars($custodian->name) ?> - <?= htmlspecialchars($custodian->position_name) ?>
                            </option>

                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Location (readonly) -->
                <div class="mb-3">
                    <label for="location_display" class="form-label">Location:</label>
                    <input type="text" id="location_display" class="form-control" readonly
                        value="<?= htmlspecialchars($item['location'] ?? '') ?>">
                    <input type="hidden" id="location_id" name="location_id" value="<?= htmlspecialchars($item['location_id'] ?? '') ?>">
                </div>

                <button type="submit" class="btn btn-success w-100">Update Item</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Populate category fields based on selected description
    function populateCategory() {
        const descriptionSelect = document.getElementById('description');
        const selectedOption = descriptionSelect.options[descriptionSelect.selectedIndex];

        if (!selectedOption) return;

        const categoryName = selectedOption.getAttribute('data-category') || '';
        const categoryId = selectedOption.getAttribute('data-category-id') || '';

        document.getElementById('category').value = categoryName;
        document.getElementById('category_id').value = categoryId;
    }

    // Populate location fields based on selected custodian
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

    // Validate that acquisition date is not in the future
    function validateDate() {
        const acquisitionDateInput = document.getElementById('acquisition_date');
        const today = new Date().toISOString().split('T')[0];

        if (acquisitionDateInput.value > today) {
            alert('Acquisition date cannot be in the future.');
            acquisitionDateInput.value = '';
            acquisitionDateInput.focus();
        }
    }

    // Run on DOM ready
    document.addEventListener('DOMContentLoaded', () => {
        populateCategory();
        setLocation();

        // Preserve search filter during edit submission
        const editForm = document.getElementById('editForm');
        const savedSearch = sessionStorage.getItem('inventorySearch');

        if (editForm && savedSearch) {
            let action = editForm.getAttribute('action');
            if (!action.includes('search=')) {
                action += (action.includes('?') ? '&' : '?') + 'search=' + encodeURIComponent(savedSearch);
                editForm.setAttribute('action', action);
            }
        }
    });
</script>


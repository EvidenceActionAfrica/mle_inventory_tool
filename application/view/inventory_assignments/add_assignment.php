<!-- CSS Links -->
<link href="<?= URL ?>css/style.css" rel="stylesheet">
<link href="<?= URL ?>css/tables.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Inline Styles -->
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
    .remove-item-btn {
        display: inline-block;
    }
    @media (max-width: 768px) {
        .card-centered {
            margin: 20px 10px;
        }
    }
</style>

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Assign Items</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= URL ?>inventoryassignment">Assignments</a></li>
        <li class="breadcrumb-item">Assign Items</li>
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

    <!-- Assignment Form -->
    <div class="card mb-4 card-centered">
        <div class="card-header">
            <i class="fas fa-plus me-1"></i>
        </div>
        <div class="card-body">
            <form action="<?= URL ?>inventoryassignment/add" method="POST">
                <!-- Dynamic Item Fields -->
                <div id="item-container">
                    <div class="row g-3 align-items-end item-group mb-3">
                        <div class="col-12">
                            <label class="form-label">Select Item</label>
                            <select name="inventory_id[]" class="form-select select2" required>
                                <option value="">Choose an item</option>
                                <?php
                                usort($unassignedItems, function ($a, $b) {
                                    return strcmp($a['description'], $b['description']);
                                });
                                foreach ($unassignedItems as $item): ?>
                                    <option value="<?= $item['id']; ?>">
                                        <?= htmlspecialchars($item['description']); ?> (<?= htmlspecialchars($item['serial_number']); ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Add another item button -->
                <button type="button" id="add-item-btn" class="btn btn-outline-primary mb-3 w-100">Add Another Item</button>

                <!-- User Selection -->
                <div class="mb-3">
                    <label class="form-label">Select User</label>
                    <select name="user_id" class="form-select" required>
                        <option value="">Select User</option>
                        <?php foreach ($users as $user): ?>
                            <?php
                                $emailPrefix = strtok($user['email'], '@');
                                $parts = preg_split('/[._]/', $emailPrefix);
                                $formattedName = implode(' ', array_map('ucfirst', array_map('strtolower', $parts)));
                            ?>
                            <option value="<?= $user['id'] ?>"><?= htmlspecialchars($formattedName) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Date Assigned -->
                <div class="mb-3">
                    <label class="form-label">Date Assigned</label>
                    <input type="date" name="date_assigned" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                </div>

                <!-- Manager -->
                <div class="mb-3">
                    <label class="form-label">Managed By</label>
                    <select name="managed_by" class="form-select" required>
                        <option value="">Select Manager</option>
                        <?php foreach ($users as $user): ?>
                            <?php
                                $emailPrefix = strtok($user['email'], '@');
                                $parts = preg_split('/[._]/', $emailPrefix);
                                $formattedName = implode(' ', array_map('ucfirst', array_map('strtolower', $parts)));
                            ?>
                            <option value="<?= htmlspecialchars($user['email']); ?>"><?= htmlspecialchars($formattedName) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Submit -->
                <button type="submit" name="add_assignment" class="btn btn-success">Assign Items</button>
            </form>
        </div>
    </div>
</div>
</main>

<!-- JavaScript for dynamic item fields -->
<script>
    document.getElementById('add-item-btn').addEventListener('click', function () {
        const container = document.getElementById('item-container');
        const newItemGroup = document.createElement('div');
        newItemGroup.classList.add('row', 'g-3', 'align-items-end', 'item-group', 'mb-3');

        newItemGroup.innerHTML = `
            <div class="col-md-10">
                <label class="form-label">Select Item</label>
                <select name="inventory_id[]" class="form-select select2" required>
                    <option value="">Choose an item</option>
                    <?php foreach ($unassignedItems as $item): ?>
                        <option value="<?= $item['id']; ?>">
                            <?= htmlspecialchars($item['description']); ?> (<?= htmlspecialchars($item['serial_number']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-2">
                <button type="button" class="btn btn-danger remove-item-btn w-100" onclick="removeItem(this)">Remove</button>
            </div>
        `;

        container.appendChild(newItemGroup);
        updateRemoveButtons();
        $('.select2').select2(); // reinitialize select2 for new element
    });

    function removeItem(button) {
        const container = document.getElementById('item-container');
        if (container.children.length > 1) {
            button.closest('.item-group').remove();
        }
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        const buttons = document.querySelectorAll('.remove-item-btn');
        buttons.forEach(btn => {
            btn.style.display = (buttons.length > 1) ? 'inline-block' : 'none';
        });
    }

    // Initial call
    updateRemoveButtons();
</script>

<!-- jQuery and Select2 -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('.select2').select2({
            placeholder: "Choose an item",
            allowClear: true
        });
    });
</script>

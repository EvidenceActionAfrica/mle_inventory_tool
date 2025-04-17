<!-- CSS Links -->
<link href="<?= URL ?>css/style.css" rel="stylesheet">
<link href="<?= URL ?>css/tables.css" rel="stylesheet">

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
    <h3 class="mt-4">Edit Item Assignment</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= URL ?>inventoryassignment">Assignments</a></li>
        <li class="breadcrumb-item">Edit Assignment</li>
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

    <!-- Assignment Edit Form -->
    <div class="card mb-4 card-centered">
        <div class="card-header">
            <i class="fas fa-edit me-1"></i> 
        </div>
        <div class="card-body">
            <form action="<?= URL ?>inventoryassignment/edit/<?= htmlspecialchars($assignment['id']); ?>" method="POST">
                <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id']); ?>">

                <!-- Existing Assigned Items -->
                <div id="item-container">
                    <?php foreach ($assignment['items'] as $item): ?>
                        <div class="row g-3 align-items-end item-group mb-3">
                            <div class="col-md-10">
                                <label class="form-label">Select Item</label>
                                <select name="inventory_id[]" class="form-select" required>
                                    <option value="">Choose an item</option>
                                    <?php foreach ($unassignedItems as $availableItem): ?>
                                        <option value="<?= $availableItem['id']; ?>" <?= $item['id'] == $availableItem['id'] ? 'selected' : ''; ?>>
                                            <?= htmlspecialchars($availableItem['description']); ?> (<?= htmlspecialchars($availableItem['serial_number']); ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-2">
                                <button type="button" class="btn btn-danger remove-item-btn w-100" onclick="removeItem(this)">Remove</button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <button type="button" id="add-item-btn" class="btn btn-outline-primary mb-3 w-100">Add Another Item</button>

                <!-- User Selection -->
                <div class="mb-3">
                    <label class="form-label">Select User</label>
                    <select name="user_id" class="form-select" required>
                        <option value="">Select User</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= $user['id'] ?>" <?= $user['id'] == $assignment['user_id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars(strtok($user['email'], '@')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>


                <!-- Date Assigned -->
                <div class="mb-3">
                    <label class="form-label">Date Assigned</label>
                    <input type="date" name="date_assigned" class="form-control" value="<?= htmlspecialchars($assignment['date_assigned']); ?>" required>
                </div>

                <!-- Manager -->
                <div class="mb-3">
                    <label class="form-label">Managed By</label>
                    <select name="managed_by" class="form-select" required>
                        <option value="">Select Manager</option>
                        <?php foreach ($users as $user): ?>
                            <option value="<?= htmlspecialchars($user['email']); ?>" <?= $user['email'] == $assignment['managed_by'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars(strtok($user['email'], '@')) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Submit -->
                <button type="submit" name="update_assignment" class="btn btn-success">Update Assignment</button>
            </form>
        </div>
    </div>
</div>
</main>

<!-- Dynamic Item Script -->
<script>
    document.getElementById('add-item-btn').addEventListener('click', function () {
        let container = document.getElementById('item-container');
        let newItemGroup = document.createElement('div');
        newItemGroup.classList.add('row', 'g-3', 'align-items-end', 'item-group', 'mb-3');

        newItemGroup.innerHTML = `
            <div class="col-md-10">
                <label class="form-label">Select Item</label>
                <select name="inventory_id[]" class="form-select" required>
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
    });

    function removeItem(button) {
        button.closest('.item-group').remove();
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.style.display = document.querySelectorAll('.item-group').length > 1 ? 'inline-block' : 'none';
        });
    }

    updateRemoveButtons();
</script>

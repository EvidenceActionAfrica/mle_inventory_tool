<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

<div class="form-container">
    <h2>Edit Item Assignment</h2>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <form action="<?php echo URL; ?>inventoryassignment/edit/<?= htmlspecialchars($assignment['id']); ?>" method="POST">
        <!-- Hidden field to hold the assignment ID -->
        <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id']); ?>">
        
        <div id="item-container">
            <?php foreach ($assignment['items'] as $item): ?>
                <div class="form-group item-group">
                    <label for="inventory_id[]">Select Item:</label>
                    <select name="inventory_id[]" required>
                        <option value="">Choose an item</option>
                        <?php foreach ($unassignedItems as $availableItem): ?>
                            <option value="<?= $availableItem['id']; ?>" <?= $item['id'] == $availableItem['id'] ? 'selected' : ''; ?>>
                                <?= htmlspecialchars($availableItem['description']); ?> (<?= htmlspecialchars($availableItem['serial_number']); ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="button" class="remove-item-btn" onclick="removeItem(this)">Remove</button>
                </div>
            <?php endforeach; ?>
        </div>

        <button type="button" id="add-item-btn">Add Another Item</button>

        <div class="form-group">
            <label for="user_id">Select User:</label>
            <select name="user_id" required>
                <option value="">Select User</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= $user['id'] ?>" <?= $user['id'] == $assignment['user_id'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars(strtok($user['email'], '@')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="location">Select Location (Office):</label>
            <select name="location" id="location" required>
                <option value="">Choose a location</option>
                <?php foreach ($offices as $office): ?>
                    <option value="<?= htmlspecialchars($office['office_name']); ?>" <?= $office['office_name'] == $assignment['location'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($office['office_name'] . " - " . $office['location_name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group">
            <label for="date_assigned">Date Assigned:</label>
            <input type="date" id="date_assigned" name="date_assigned" value="<?= htmlspecialchars($assignment['date_assigned']); ?>" required>
        </div>

        <div class="form-group">
            <label for="managed_by">Managed By:</label>
            <select name="managed_by" required>
                <option value="">Select Manager</option>
                <?php foreach ($users as $user): ?>
                    <option value="<?= htmlspecialchars($user['email']); ?>" <?= $user['email'] == $assignment['managed_by'] ? 'selected' : ''; ?>>
                        <?= htmlspecialchars(strtok($user['email'], '@')) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <button type="submit" name="update_assignment" class="submit-btn">Update Assignment</button>
    </form>
</div>

<script>
    document.getElementById('add-item-btn').addEventListener('click', function () {
        let container = document.getElementById('item-container');
        let newItemGroup = document.createElement('div');
        newItemGroup.classList.add('form-group', 'item-group');

        newItemGroup.innerHTML = `
            <label for="inventory_id[]">Select Item:</label>
            <select name="inventory_id[]" required>
                <option value="">Choose an item</option>
                <?php foreach ($unassignedItems as $availableItem): ?>
                    <option value="<?= $availableItem['id']; ?>">
                        <?= htmlspecialchars($availableItem['description']); ?> (<?= htmlspecialchars($availableItem['serial_number']); ?>)
                    </option>
                <?php endforeach; ?>
            </select>
            <button type="button" class="remove-item-btn" onclick="removeItem(this)">Remove</button>
        `;

        container.appendChild(newItemGroup);
        updateRemoveButtons();
    });

    function removeItem(button) {
        button.parentElement.remove();
        updateRemoveButtons();
    }

    function updateRemoveButtons() {
        document.querySelectorAll('.remove-item-btn').forEach(button => {
            button.style.display = document.querySelectorAll('.item-group').length > 1 ? 'inline-block' : 'none';
        });
    }

    updateRemoveButtons();
</script>

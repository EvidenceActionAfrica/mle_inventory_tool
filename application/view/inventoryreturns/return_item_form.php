<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<div class="form-container">
    <h2>Record Returned Items</h2>

    <?php if (!empty($items)): ?>
        <form action="<?= URL; ?>inventoryreturn/add" method="post">
            <div class="form-group">
                <label for="inventory_ids[]">Select Items to Return:</label>
                <select name="inventory_ids[]" id="inventory_ids" multiple required>
        <?php foreach ($items as $item): ?>
            <option value="<?= htmlspecialchars($item['id']); ?>">
                <?= htmlspecialchars($item['description']); ?> (Serial: <?= htmlspecialchars($item['serial_number']); ?>)
            </option>
        <?php endforeach; ?>
    </select>
            </div>

            <div class="form-group">
                <label for="return_date">Return Date:</label>
                <input type="date" id="return_date" name="return_date" required>
            </div>

            <div class="form-group">
                <label for="receiver_id">Select Receiver:</label>
                <select name="receiver_id" required>
                    <option value="">Select Receiver</option>
                    <?php foreach ($receivers as $receiver): ?>
                        <option value="<?= $receiver['id']; ?>">
                            <?= htmlspecialchars($receiver['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="status" value="pending" readonly>
            <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment_id) ?>">
            <button type="submit" class="submit-btn">Record Return</button>
        </form>
    <?php else: ?>
        <p>No items to return.</p>
    <?php endif; ?>
</div>

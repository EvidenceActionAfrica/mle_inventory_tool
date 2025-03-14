    <link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

    <h2>Item Assignments</h2>

    <!-- Success & Error Messages -->
    <?php if (isset($_GET['success'])): ?>
        <p class="success-message"><?= htmlspecialchars($_GET['success']); ?></p>
    <?php elseif (isset($_GET['error'])): ?>
        <p class="error-message"><?= htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <!-- Top Bar (Search + Add Button + Filter) -->
    <div class="top-bar">
        <!-- Search Form -->
        

        <!-- Assign New Item Button -->
        <form action="<?php echo URL; ?>inventoryassignment/add" method="GET">
            <button type="submit" class="add-btn">Assign New Item</button>
        </form>
    </div>

    <!-- Assignments Table -->
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Location</th>
                <th>Item</th>
                <th>Serial Number</th>
                <th>Date Assigned</th>
                <th>Managed By</th>
                <th>Acknowledgment Status</th>
                <!-- <th>Actions</th> -->
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($assignments)): ?>
                <?php foreach ($assignments as $assignment): ?>
                    <tr>
                        <td><?= htmlspecialchars($assignment['user_name'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($assignment['email'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars(($assignment['department'] ?? 'N/A') . ' - ' . ($assignment['position'] ?? 'N/A')); ?></td>
                        <td><?= htmlspecialchars($assignment['location'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars(($assignment['description'] ?? 'N/A')  ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($assignment['serial_number'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($assignment['date_assigned'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($assignment['managed_by'] ?? 'N/A'); ?></td>
                        <td>
                            <span class="<?= $assignment['acknowledgment_status'] === 'acknowledged' ? 'status-acknowledged' : 'status-pending'; ?>">
                                <?= $assignment['acknowledgment_status'] === 'acknowledged' ? 'Acknowledged' : 'Pending'; ?>
                            </span>
                        </td>
                        <td>
                        <!-- <a href="<?= URL ?>inventoryassignment/edit?assignment_id=<?= htmlspecialchars($assignment['id']); ?>">Edit</a> -->
                            <!-- Delete Form: Only allow deleting unacknowledged assignments -->
                            <?php if ($assignment['acknowledgment_status'] !== 'acknowledged'): ?>
                                <form action="<?= URL; ?>InventoryAssignment/delete" method="POST" 
                                    onsubmit="return confirm('Are you sure you want to delete this assignment?');" style="display:inline;">
                                    <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id']); ?>">
                                    <!-- <button type="submit" name="delete" class="delete-btn">Delete</button> -->
                                </form>
                            <?php else: ?>
                                <!-- <button class="delete-btn" disabled>Delete</button> -->
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10">No item assignments found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>

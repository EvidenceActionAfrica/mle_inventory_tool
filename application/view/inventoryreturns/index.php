<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<div class="container mt-5">
    <h2 style="text-decoration: underline;">Your Assigned Items</h2>

    <table class="styled-table">
        <thead>
            <tr>
                <th>Email</th>
                <th>Role</th>
                <th>Location</th>
                <th>Item</th>
                <th>Serial Number</th>
                <th>Date Assigned</th>
                <th>Managed By</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($approvedAssignments)): ?>
                <?php foreach ($approvedAssignments as $assignment): ?>
                    <tr>
                        <td><?= htmlspecialchars($assignment['email'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars(($assignment['department'] ?? 'N/A') . ' - ' . ($assignment['position'] ?? 'N/A')); ?></td>
                        <td><?= htmlspecialchars($assignment['location'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($assignment['description'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($assignment['serial_number'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($assignment['date_assigned'] ?? 'N/A'); ?></td>
                        <td><?= htmlspecialchars($assignment['managed_by'] ?? 'N/A'); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align: center;">You don't have any approved assigned items.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="container mt-5">
    <!-- Returned Items Table -->
    <h2 style="text-decoration: underline;">Returned Items</h2>
    
    <div style="margin-top: 2px; text-align: right;">
        <!-- Record Return Button -->
        <form action="<?= URL; ?>inventoryreturn/add" method="GET" style="display: inline;">
            <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id'] ?? 0); ?>">
            <button type="submit" class="add-btn">
                Record Return
            </button>
        </form>
    </div>
    <table class="styled-table">
        <thead>
            <tr>
                <th>Item Name</th>
                <th>Serial Number</th>
                <th>Received By</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if (!empty($returnedItems)): ?>
        <?php foreach ($returnedItems as $return): ?>
            <tr>
                <td><?= htmlspecialchars($return['description']); ?></td>
                <td><?= htmlspecialchars($return['serial_number']); ?></td>
                <td><?= htmlspecialchars($return['receiver_name']); ?></td>
                <td><?= htmlspecialchars($return['return_date']); ?></td>
                <td><?= htmlspecialchars($return['status']); ?></td>
                <td>
                    <?php if ($return['status'] === 'pending'): ?>
                        <a href="<?= URL; ?>inventoryreturn/delete?id=<?= $return['id']; ?>" 
                        onclick="return confirm('Are you sure you want to delete this pending return?');">
                        Delete
                        </a>
                    <?php else: ?>
                        N/A
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="6">No returned items found.</td>
        </tr>
    <?php endif; ?>

        </tbody>
    </table>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>



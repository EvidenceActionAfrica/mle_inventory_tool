<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Returned Items</title>
    <link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
</head>
<body>

<?php if (isset($_GET['success'])): ?>
    <p class="success-message"><?= htmlspecialchars($_GET['success']); ?></p>
<?php elseif (isset($_GET['error'])): ?>
    <p class="error-message"><?= htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>
<div class="container mt-5">
    <h2 style="text-decoration: underline;">Your Approved Assigned Items</h2>

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



<div class="row">
    <div class="col-md-10">
        <!-- Search Bar -->
    </div>
    <div class="col-md-2">
    <!-- Record Return Button -->
    <form action="<?= URL; ?>inventoryreturn/add" method="GET">
    <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id'] ?? 0); ?>">
    <button type="submit" class="add-btn">Record Return</button>
</form>

</div>

</div>
</div>
<div class="container mt-5">
    <!-- Returned Items Table -->
    <h2 style="text-decoration: underline;">Returned Items</h2>
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
                    <td><?= htmlspecialchars($return['name']); ?></td>
                    <td><?= htmlspecialchars($return['return_date']); ?></td>
                    <td><?= htmlspecialchars($return['status']); ?></td>
                    <td>
                        <?php if ($return['status'] === 'pending'): ?>
                            <a href="<?= URL; ?>item-returns/delete?id=<?= $return['id']; ?>" 
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

</body>
</html>

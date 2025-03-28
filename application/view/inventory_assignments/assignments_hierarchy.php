<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']); // Clear the message after displaying
}
?>

<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

<h2>Users Assigned Assignments</h2>

<!-- Success & Error Messages -->
<?php if (isset($_GET['success'])): ?>
    <p class="success-message"><?= htmlspecialchars($_GET['success']); ?></p>
<?php elseif (isset($_GET['error'])): ?>
    <p class="error-message"><?= htmlspecialchars($_GET['error']); ?></p>
<?php endif; ?>

<!-- Top Bar (Search + Add Button + Filter) -->
<div class="top-bar">
    <!-- Search Form -->
    <form method="GET" action="<?= URL ?>InventoryAssignment/managerAssignments" class="search-form">
        <input type="text" name="search" placeholder="Search by Username, Tag, Serial Number, or Status" 
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>
        <button type="submit" aria-label="Search for inventory assignments">Search</button>

        <?php if (!empty($_GET['search'])): ?>
            <a href="<?= URL ?>InventoryAssignment/managerAssignments" class="reset-search" aria-label="Reset search">Reset</a>
        <?php endif; ?>
    </form>
    
    <div class="col-md-4 text-end">
            <a href="<?= URL; ?>InventoryAssignment/downloadAssignments" 
            class="add-btn" 
            style="background-color: #05545a; border-color: #05545a;">
            Download
            </a>
        </div>
    </div>
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
            <th>Actions</th>
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
                        <?php if ($assignment['acknowledgment_status'] === 'pending'): ?>
                            <a href="<?= URL ?>inventoryassignment/edit/<?= $assignment['id']; ?>">Edit</a>
                        <?php else: ?>
                            <span>N/A</span>
                        <?php endif; ?>

                        <?php if ($assignment['acknowledgment_status'] === 'pending'): ?>
                            <form action="<?= URL; ?>inventoryassignment/delete" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this assignment?');" style="display:inline;">
                                <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id']); ?>">
                                <button type="submit" name="delete" class="delete-btn">Delete</button>
                            </form>
                        <?php else: ?>
                            <span>N/A</span>
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

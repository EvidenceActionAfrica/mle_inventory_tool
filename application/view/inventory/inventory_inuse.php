<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<div>
    <h2>Items Currently In Use</h2>
    <!-- Top Bar (Search) -->
    <div class="d-flex justify-content-end align-items-center mb-3">
            <form method="GET" action="<?= URL ?>inventoryreturn/searchAssignedItems" class="search-form" style="width: 33%;">
                <input type="text" name="search" placeholder="Search by Description, Serial No., or Tag No." 
                    class="form-control me-2" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="<?= URL ?>inventoryreturn/assignedItems" class="reset-search">Reset</a>
                <?php endif; ?>
            </form>
        </div>

    <!-- Items Table -->
    <table>
        <thead>
            <tr>
                <th>User</th>
                <th>Email</th>
                <th>Category</th>
                <th>Description</th>
                <th>Serial Number</th>
                <th>Tag Number</th>
                <th>Date Assigned</th>
                <th>Managed By</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($assignedItems)): ?>
                <?php foreach ($assignedItems as $item) : ?>
                    <tr>
                        <td><?= htmlspecialchars($item['user_name']) ?></td>
                        <td><?= htmlspecialchars($item['assigned_user_email']) ?></td>
                        <td><?= htmlspecialchars($item['category']) ?></td>
                        <td><?= htmlspecialchars($item['description']) ?></td>
                        <td><?= htmlspecialchars($item['serial_number']) ?></td>
                        <td><?= htmlspecialchars($item['tag_number']) ?></td>
                        <td><?= htmlspecialchars($item['date_assigned']) ?></td>
                        <td><?= htmlspecialchars($item['managed_by']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="text-center">No items found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

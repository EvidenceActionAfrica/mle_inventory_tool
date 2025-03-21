<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<div class="container mt-5">
    <!-- Returned Items Table -->
    <h2 style="text-decoration: underline;">Staff Returned Items</h2>
    
    <div style="margin-top: 2px; text-align: right;">
    <form method="GET" action="<?= URL ?>inventoryreturn/returnedItems" class="search-form">
        <input type="text" name="search" placeholder="Search by Username, Tag, Serial Number, or Status" 
            value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>
        <button type="submit" aria-label="Search for inventory assignments">Search</button>

        <?php if (!empty($_GET['search'])): ?>
            <a href="<?= URL ?>inventoryreturn/returnedItems" class="reset-search" aria-label="Reset search">Reset</a>
        <?php endif; ?>
    </form>
    </div>
    <table class="styled-table">
    <thead>
        <tr>
            <th>Returned By</th>
            <th>Description</th>
            <th>Serial Number</th>
            <th>Return Date</th>
            <th>Status</th>
            <th>Received By</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($returnedItems)): ?>
            <?php foreach ($returnedItems as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['returned_by_name']) ?></td>
                    <td><?= htmlspecialchars($item['description']) ?></td>
                    <td><?= htmlspecialchars($item['serial_number']) ?></td>
                    <td><?= htmlspecialchars($item['return_date']) ?></td>
                    <td><?= htmlspecialchars($item['status']) ?></td>
                    <td><?= htmlspecialchars($item['receiver_name']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="7">No returned items found.</td>
            </tr>
        <?php endif; ?>
    </tbody>
    </table>
</div>
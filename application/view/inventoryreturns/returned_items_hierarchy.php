<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['error_message'])) {
    echo "<div class='alert alert-danger'>" . $_SESSION['error_message'] . "</div>";
    unset($_SESSION['error_message']); 
}
?>

<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<div>
    <h2 style="text-decoration: underline;">Staff Returned Items</h2>
    
    <div class="top-bar">
    <!-- Search Form-->
        <form method="GET" action="<?= URL ?>inventoryreturn/returnedItems" class="d-flex">
            <input type="text" name="search" 
                class="form-control me-2" 
                placeholder="Search by Username, Tag, Serial Number, or Status" 
                value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>

            <button type="submit" class="btn btn-dark" aria-label="Search for inventory assignments">Search</button>

            <?php if (!empty($_GET['search'])): ?>
                <a href="<?= URL ?>inventoryreturn/returnedItems" 
                   class="btn btn-outline-danger ms-2" 
                   aria-label="Reset search">Reset</a>
            <?php endif; ?>
        </form>

    <!-- Download Button-->
    <div class="col-md-4 text-end">
            <a href="<?= URL; ?>inventoryreturn/downloadReturnedItems" 
            class="add-btn" 
            style="background-color: #05545a; border-color: #05545a;">
            Download
            </a>
        </div>
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


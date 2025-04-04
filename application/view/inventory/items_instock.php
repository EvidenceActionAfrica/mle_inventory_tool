<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
    <div >
        <h2>Items In Stock</h2>

        <!-- Success/Error Messages -->
        <?php if (isset($_GET['success'])): ?>
            <p class="success-message"><?= htmlspecialchars($_GET['success']); ?></p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error-message"><?= htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <!-- Top Bar (Search Button) -->
        <div class="d-flex justify-content-end align-items-center mb-3">
            <form method="GET" action="<?= URL ?>inventoryreturn/searchUnassignedItems" class="search-form" style="width: 33%;">
                <input type="text" name="search" placeholder="Search by Description, Serial No., or Tag No." 
                    class="form-control me-2" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="<?= URL ?>inventoryreturn/unassignedItems" class="reset-search">Reset</a>
                <?php endif; ?>
            </form>
        </div>
        
        <!-- Inventory Table -->
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Serial Number</th>
                    <th>Tag Number</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($unassignedItems)): ?>
                <?php foreach ($unassignedItems as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['category']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><?= htmlspecialchars($item['serial_number']) ?></td>
                            <td><?= htmlspecialchars($item['tag_number']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No items in stock found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>


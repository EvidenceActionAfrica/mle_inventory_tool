    <link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
    <div>
        <h2>Damaged Items</h2>
        <!-- Success/Error Messages -->
        <?php if (isset($_GET['success'])): ?>
            <p class="success-message"><?= htmlspecialchars($_GET['success']); ?></p>
        <?php elseif (isset($_GET['error'])): ?>
            <p class="error-message"><?= htmlspecialchars($_GET['error']); ?></p>
        <?php endif; ?>

        <!-- Top Bar (Search) -->
        <div class="d-flex justify-content-end align-items-center mb-3">
            <form method="GET" action="<?= URL ?>inventoryreturn/searchDamagedItems" class="search-form" style="width: 33%;">
                <input type="text" name="search" placeholder="Search by Description, Serial No., or Tag No." 
                    class="form-control me-2" value="<?= isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" required>
                <button type="submit" class="btn btn-primary">Search</button>
                <?php if (!empty($_GET['search'])): ?>
                    <a href="<?= URL ?>inventoryreturn/damagedItems" class="reset-search">Reset</a>
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
                    <th>Repair Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($damagedItems)): ?>
                    <?php foreach ($damagedItems as $item) : ?>
                        <tr>
                            <td><?= htmlspecialchars($item['category']) ?></td>
                            <td><?= htmlspecialchars($item['description']) ?></td>
                            <td><?= htmlspecialchars($item['serial_number']) ?></td>
                            <td><?= htmlspecialchars($item['tag_number']) ?></td>
                            <td>
                                <?php
                                if ($item['repair_status']) {
                                    echo htmlspecialchars($item['repair_status']);
                                } else {
                                    echo "<span class='text-warning'>Pending</span>";
                                }
                                ?>
                            </td>
                            <td>
                                <?php if (!isset($item['repair_status']) || empty($item['repair_status'])): ?>
                                    <form method="POST" action="<?= URL ?>inventoryreturn/updateRepairStatus">
                                        <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['item_id']); ?>">
                                        <select name="repair_status" class="form-select form-select-sm" required>
                                            <option value="">Select</option>
                                            <option value="Repairable">Repaired</option>
                                            <option value="Unrepairable">Unrepairable</option>
                                        </select>
                                        <button type="submit" class="btn btn-sm btn-primary mt-1">Update</button>
                                    </form>

                                <?php else: ?>
                                    <span class="text-muted">Updated</span>
                                <?php endif; ?>
                            </td>

                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No damaged items found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

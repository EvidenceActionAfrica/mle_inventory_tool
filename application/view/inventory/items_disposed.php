<link href="<?= URL; ?>css/tables.css" rel="stylesheet">

<div class="container mt-5">
    <h2>Disposed Items</h2>
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

    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Serial Number</th>
                <th>Category</th>
                <th>Returned By</th>
                <th>Reason</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($disposedItems)): ?>
                <?php foreach ($disposedItems as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['description']); ?></td>
                        <td><?= htmlspecialchars($item['serial_number']); ?></td>
                        <td><?= htmlspecialchars($item['category_name']); ?></td>
                        <td><?= htmlspecialchars($item['returned_by']); ?></td>
                        <td>
                            <?= $item['item_state'] === 'lost' ? 'Lost' : ($item['repair_status'] === 'Unrepairable' ? 'Unrepairable' : ''); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="text-center">No disposed items at the moment.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>


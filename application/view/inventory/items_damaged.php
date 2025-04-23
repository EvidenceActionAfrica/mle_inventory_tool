<!-- CSS Files -->
<link href="<?= URL ?>css/style.css" rel="stylesheet">
<link href="<?= URL ?>css/tables.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Damaged Items</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item">Collections</li>
        <li class="breadcrumb-item">Damaged Items</li>
    </ol>

    <!-- Alert Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Intro Card -->
    <div class="card mb-4">
        <div class="card-body">
            These are items that are currently marked as damaged and pending a repair status update.
        </div>
    </div>

    <!-- Search and Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-tools me-1"></i> 
        </div>
        <div class="card-body table-responsive">
            <!-- Data Table -->
            <table id="damagedItemsTable">
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
                                    <?php if ($item['repair_status']): ?>
                                        <?= htmlspecialchars($item['repair_status']) ?>
                                    <?php else: ?>
                                        <span class="text-warning">Pending</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if (empty($item['repair_status'])): ?>
                                        <form method="POST" action="<?= URL ?>inventoryreturn/updateRepairStatus" class="d-flex flex-column">
                                            <input type="hidden" name="item_id" value="<?= htmlspecialchars($item['item_id']); ?>">
                                            <select name="repair_status" class="form-select form-select-sm mb-1" required>
                                                <option value="">Select</option>
                                                <option value="Repairable">Repaired</option>
                                                <option value="Unrepairable">Unrepairable</option>
                                            </select>
                                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
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
    </div>
</div>
</main>

<!-- JS Files -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const table = document.getElementById('damagedItemsTable');
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });
</script>

<!-- CSS Files -->
<link href="<?= URL; ?>css/style.css" rel="stylesheet">
<link href="<?= URL; ?>css/tables.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Disposed Items</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item">Collections</li>
        <li class="breadcrumb-item">Disposed Items</li>
    </ol>
    <div class="card mb-4">
        <div class="card-body">
            This is a combination of lost items and irrepairable items.
        </div>
    </div>
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
    <!-- Disposed Items Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-trash-alt me-1"></i> 
        </div>
        <div class="card-body table-responsive">
            <table id="disposedItemsTable">
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
    </div>
</div>
</main>

<!-- JS Files -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const table = document.getElementById('disposedItemsTable');
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });
</script>

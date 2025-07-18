<!-- CSS Files -->
<link href="<?= URL ?>css/style.css" rel="stylesheet">
<link href="<?= URL ?>css/tables.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Lost Items</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item">Collections</li>
        <li class="breadcrumb-item">Lost Items</li>
    </ol>

    <!-- Alert Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <!-- Search Bar -->
    <div class="card mb-4">
        <div class="card-body">
            These are items that have been misplaced or damaged beyond repair.
        </div>
    </div>

    <!-- Lost Items Table -->
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-box-open me-1"></i>
        </div>
        <div class="card-body table-responsive">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Serial Number</th>
                        <th>Tag Number</th>
                        <th>Reported Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($lostItems)): ?>
                        <?php foreach ($lostItems as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['category']) ?></td>
                                <td><?= htmlspecialchars($item['description']) ?></td>
                                <td><?= htmlspecialchars($item['serial_number']) ?></td>
                                <td><?= htmlspecialchars(isset($item['tag_number']) ? $item['tag_number'] : '') ?></td>
                                <td><?= htmlspecialchars($item['approved_date']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No lost items found.</td>
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
        const table = document.getElementById('datatablesSimple');
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });
</script>

<!-- CSS Files -->
<link rel="stylesheet" href="<?php echo URL; ?>css/tables.css">
<link rel="stylesheet" href="<?php echo URL; ?>css/style.css">
<!-- Simple DataTables CSS -->
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Items In Stock</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Items In Stock</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            These are items that are currently available and not assigned to any user.
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-boxes me-1"></i>
        </div>
        <div class="card-body">
            <!-- Success/Error Messages -->
            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
            <?php elseif (isset($_GET['error'])): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
            <?php endif; ?>

            <!-- Items Table -->
            <table id="datatablesSimple">
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
                        <?php foreach ($unassignedItems as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['category']) ?></td>
                                <td><?= htmlspecialchars($item['description']) ?></td>
                                <td><?= htmlspecialchars($item['serial_number']) ?></td>
                                <td><?= htmlspecialchars($item['tag_number']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No items in stock found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

<!-- Simple DataTables JS -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const datatablesSimple = document.getElementById('datatablesSimple');
        if (datatablesSimple) {
            new simpleDatatables.DataTable(datatablesSimple);
        }
    });
</script>

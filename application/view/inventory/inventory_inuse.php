<!-- CSS Files -->
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
<!-- Simple DataTables CSS -->
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Items Currently In Use</h3>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
            <li class="breadcrumb-item">Items In Use</li>
        </ol>

        <div class="card mb-4">
            <div class="card-body">
                This page displays all items that are currently assigned and actively in use by users.
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-boxes me-1"></i>
            </div>
            <div class="card-body table-responsive">
                <!-- Table -->
                <table id="datatablesSimple">
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

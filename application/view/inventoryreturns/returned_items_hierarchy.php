<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Staff Returned Items</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Returned Items</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            List of items returned by supervisees.
        </div>
    </div>

    <!-- Top Bar (Download Button) -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i></span>           
            <div class="col-md-4 text-end">
                <a href="<?= URL; ?>inventoryreturn/downloadReturnedItems" 
                class="add-btn" 
                style="background-color: #05545a; border-color: #05545a;">
                Download
                </a>
            </div>
        </div>

        <!-- DataTable -->
        <div class="card-body">
            <table id="datatablesSimple" class="styled-table">
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
                            <td colspan="6" class="text-center">No returned items found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Success & Error Messages -->
    <?php if (isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error_message']); ?></div>
        <?php unset($_SESSION['error_message']); ?>
    <?php elseif (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>
</div>
</main>

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const datatable = document.getElementById('datatablesSimple');
        if (datatable) {
            new simpleDatatables.DataTable(datatable);
        }
    });
</script>

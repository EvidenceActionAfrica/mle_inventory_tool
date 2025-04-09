<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Inventory List</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Inventory</li>
    </ol>
    
    <!-- Success & Error Messages -->
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
    <?php elseif (isset($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <!-- Card for inventory list -->
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i></span>
            <form method="GET" action="<?= URL ?>inventory/add" class="mb-0">
                <button type="submit" class="add-btn">Add New Item</button>
            </form>
        </div>

        <div class="card-body">
            <!-- Inventory Table -->
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Serial Number</th>
                        <th>Tag Number</th>
                        <th>Acquisition Date</th>
                        <th>Acquisition Cost ($)</th>
                        <th>Warranty Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($items)): ?>
                        <?php foreach ($items as $item): ?>
                            <tr>
                                <td><?= htmlspecialchars($item['category'] ?? "N/A"); ?></td>
                                <td><?= htmlspecialchars($item['description']); ?></td>
                                <td><?= htmlspecialchars($item['serial_number']); ?></td>
                                <td><?= htmlspecialchars($item['tag_number']); ?></td>
                                <td><?= htmlspecialchars($item['acquisition_date']); ?></td>
                                <td><?= htmlspecialchars($item['acquisition_cost']); ?></td>
                                <td><?= htmlspecialchars($item['warranty_date']); ?></td>
                                <td>
                                    <a href="<?= URL ?>inventory/edit/<?= htmlspecialchars($item['id']); ?>" class="btn btn-sm btn-outline-primary">Edit</a> |
                                    <form action="<?= URL ?>inventory/delete" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this item?');" 
                                          style="display:inline;">
                                        <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']); ?>">
                                        <button type="submit" name="delete" class="btn btn-sm btn-outline-danger">Delete</button>
                                    </form>
                                </td>
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

<script>
    window.addEventListener('DOMContentLoaded', () => {
        const datatable = document.getElementById('datatablesSimple');
        if (datatable) {
            new simpleDatatables.DataTable(datatable);
        }
    });
</script>

<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<main>
<div class="container-fluid px-4">
<h3 class="mt-4">Assigned Items</h3>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
    <li class="breadcrumb-item">Assignments</li>
</ol>
<div class="card mb-4">
    <div class="card-body">
        This page displays a list of items loaned to you.
    </div>
</div>
<!-- Approved Assignments -->
<div class="card mb-4">
    <div class="card-header">
        <i class="fas fa-check-circle me-1"></i>
    </div>
    <div class="card-body">

        <!-- Success & Error Messages -->
        <?php if (isset($_SESSION['success'])): ?>
            <div class="alert alert-success"><?= $_SESSION['success']; ?></div>
            <?php unset($_SESSION['success']); ?>
        <?php endif; ?>
        <?php if (isset($_SESSION['error'])): ?>
            <div class="alert alert-danger"><?= $_SESSION['error']; ?></div>
            <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <table id="approvedItemsTable">
            <thead>
                <tr>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Location</th>
                    <th>Item</th>
                    <th>Serial Number</th>
                    <th>Date Assigned</th>
                    <th>Managed By</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($approvedAssignments)): ?>
                    <?php foreach ($approvedAssignments as $assignment): ?>
                        <tr>
                            <td><?= htmlspecialchars($assignment['email'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars(($assignment['department'] ?? 'N/A') . ' - ' . ($assignment['position'] ?? 'N/A')); ?></td>
                            <td><?= htmlspecialchars($assignment['location'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($assignment['description'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($assignment['serial_number'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($assignment['date_assigned'] ?? 'N/A'); ?></td>
                            <td><?= htmlspecialchars($assignment['managed_by'] ?? 'N/A'); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="7" class="text-center">You don't have any approved assigned items.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<h3 class="mt-4">Returned Items</h3>
<div class="card mb-4">
    <div class="card-body">
        This is a list of items you have returned.
    </div>
</div>
<!-- Returned Items -->
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <span><i class="fas fa-undo me-1"></i></span>

        <!-- Record Return Button -->
        <form action="<?= URL; ?>inventoryreturn/add" method="GET" class="mb-0">
            <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id'] ?? 0); ?>">
            <button type="submit" class="add-btn">Record Return</button>
        </form>
    </div>

    <div class="card-body">
        <table id="returnedItemsTable">
            <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Serial Number</th>
                    <th>Received By</th>
                    <th>Return Date</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($returnedItems)): ?>
                    <?php foreach ($returnedItems as $return): ?>
                        <tr>
                            <td><?= htmlspecialchars($return['description']); ?></td>
                            <td><?= htmlspecialchars($return['serial_number']); ?></td>
                            <td><?= htmlspecialchars($return['receiver_name']); ?></td>
                            <td><?= htmlspecialchars($return['return_date']); ?></td>
                            <td>
                                <span class="badge <?= $return['status'] === 'approved' ? 'bg-success' : 'bg-warning text-dark'; ?>">
                                    <?= ucfirst($return['status']); ?>
                                </span>
                            </td>
                            <td>
                                <?php if ($return['status'] === 'pending'): ?>
                                    <a href="<?= URL; ?>inventoryreturn/delete?id=<?= $return['id']; ?>" 
                                       onclick="return confirm('Are you sure you want to delete this pending return?');"
                                       class="btn btn-sm btn-outline-danger">
                                       Delete
                                    </a>
                                <?php else: ?>
                                    <span class="text-muted">N/A</span>
                                <?php endif; ?>
                            </td>
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
</div>
</main>
<!-- SimpleDatatables Initialization -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const approvedTable = document.getElementById('approvedItemsTable');
        const returnedTable = document.getElementById('returnedItemsTable');
        if (approvedTable) new simpleDatatables.DataTable(approvedTable);
        if (returnedTable) new simpleDatatables.DataTable(returnedTable);
    });
</script>

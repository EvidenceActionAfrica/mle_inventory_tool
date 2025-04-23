<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Users Assigned Items</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
        <li class="breadcrumb-item">Report</li>
        <li class="breadcrumb-item">Staff Assignments</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            Items assigned to your supervisees.
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i></span>           
            <div class="col-md-4 text-end">
                <form action="<?= URL; ?>InventoryAssignment/downloadAssignments" method="GET" class="mb-0">
                    <button type="submit" class="add-btn" 
                        style="background-color: #05545a; border-color: #05545a;">
                        Download
                    </button>
                </form>
            </div>

        </div>
         <!-- DataTable -->
        <div class="card-body table-responsive">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Location</th>
                        <th>Item</th>
                        <th>Serial Number</th>
                        <th>Date Assigned</th>
                        <th>Managed By</th>
                        <th>Acknowledgment Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($assignments)): ?>
                        <?php foreach ($assignments as $assignment): ?>
                            <tr>
                                <td><?= htmlspecialchars($assignment['user_name'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($assignment['email'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars(($assignment['department'] ?? 'N/A') . ' - ' . ($assignment['position'] ?? 'N/A')); ?></td>
                                <td><?= htmlspecialchars($assignment['location'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars(($assignment['description'] ?? 'N/A')  ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($assignment['serial_number'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($assignment['date_assigned'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($assignment['managed_by'] ?? 'N/A'); ?></td>
                                <td>
                                    <span class="<?= $assignment['acknowledgment_status'] === 'acknowledged' ? 'badge bg-success' : 'badge bg-warning text-dark'; ?>">
                                        <?= ucfirst($assignment['acknowledgment_status'] ?? 'Pending'); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php if ($assignment['acknowledgment_status'] === 'pending'): ?>
                                        <a href="<?= URL ?>inventoryassignment/edit/<?= $assignment['id']; ?>" class="btn btn-sm btn-outline-primary">Edit</a>

                                        <form action="<?= URL; ?>inventoryassignment/delete" method="POST" 
                                            onsubmit="return confirm('Are you sure you want to delete this assignment?');" 
                                            style="display:inline;">
                                            <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id']); ?>">
                                            <button type="submit" name="delete" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    <?php else: ?>
                                        <span class="text-muted">N/A</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">No item assignments found.</td>
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

<!-- CSS Files -->
<link rel="stylesheet" href="<?php echo URL; ?>css/tables.css">
<link rel="stylesheet" href="<?php echo URL; ?>css/style.css">
<!-- Simple DataTables CSS -->
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<main>
<div class="container-fluid px-4">
<h3 class="mt-4">Pending Assignments</h3>

<ol class="breadcrumb mb-4">
    <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
    <li class="breadcrumb-item">Pending Assignments</li>
</ol>
<div class="card mb-4">
    <div class="card-body">
        Items assigned to you and are pending your acknowledgement.Kindly confirm receipt to proceed with approval.
    </div>
</div>
<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <i class="fas fa-tasks me-1"></i>
        <form action="<?= URL ?>inventoryassignment/acknowledgeAll" method="POST" 
            onsubmit="return confirm('Are you sure you want to acknowledge all assigned items? This action cannot be undone.');">
            <button type="submit" class="add-btn">
                Acknowledge All Items
            </button>
        </form>
    </div>
    <div class="card-body table-responsive">
        <?php if (!empty($_GET['success'])): ?>
            <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
        <?php endif; ?>

        <?php if (!empty($_GET['error'])): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
        <?php endif; ?>

        <table id="datatablesSimple">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Email</th>
                    <th>Description</th>
                    <th>Serial Number</th>
                    <th>Tag Number</th>
                    <th>Date Assigned</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tfoot>
            <tbody>
                <?php if (!empty($pendingAssignments)): ?>
                    <?php foreach ($pendingAssignments as $assignment): ?>
                        <tr>
                            <td><?= htmlspecialchars($assignment['user_name']); ?></td>
                            <td><?= htmlspecialchars($assignment['email']); ?></td>
                            <td><?= htmlspecialchars($assignment['description']); ?></td>
                            <td><?= htmlspecialchars($assignment['serial_number']); ?></td>
                            <td><?= htmlspecialchars(isset($assignment['tag_number']) ? $assignment['tag_number'] : '') ?></td>
                            <td><?= htmlspecialchars($assignment['date_assigned']); ?></td>
                            <td>
                                <form action="<?= URL ?>inventoryassignment/acknowledge" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure you want to acknowledge this item?');">
                                    <input type="hidden" name="assignment_id" value="<?= $assignment['id'] ?>">
                                    <button type="submit" class="btn btn-success btn-sm">Acknowledge</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="6" class="text-center">No pending assignments found.</td></tr>
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

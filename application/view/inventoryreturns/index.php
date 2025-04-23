<link href="<?= URL ?>css/tables.css" rel="stylesheet">
<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Assigned Items</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
            <li class="breadcrumb-item">My Items</li>
            <li class="breadcrumb-item">Assigned Assignments</li>
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
            <div class="card-body table-responsive">
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
                            <th>Item</th>
                            <th>Serial Number</th>
                            <th>Date Assigned</th>
                            <th>Managed By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($approvedAssignments)): ?>
                            <?php foreach ($approvedAssignments as $assignment): ?>
                                <tr>
                                    <td><?= htmlspecialchars($assignment['description'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($assignment['serial_number'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($assignment['date_assigned'] ?? 'N/A'); ?></td>
                                    <td><?= htmlspecialchars($assignment['managed_by'] ?? 'N/A'); ?></td>
                                    <td>
                                    <?php
                                        $enabled = isset($assignment['reconfirm_enabled']) ? (int)$assignment['reconfirm_enabled'] : 0;
                                        $confirmed = isset($assignment['confirmed']) ? (int)$assignment['confirmed'] : 0;
                                        $confirmationDate = $assignment['confirmation_date'] ?? null;

                                        // Check if there's an active reconfirmation session
                                        $activeSession = $this->model->getActiveReconfirmationSession();
                                        $sessionActive = !empty($activeSession) && $activeSession['active'] == 1;
                                    ?>

                                    <?php if ($confirmed === 1): ?>
                                        <span class="text-success">Confirmed</span><br>
                                        <?php if (!empty($confirmationDate)): ?>
                                            <small>Last Confirmed on: <?= htmlspecialchars(date('Y-m-d', strtotime($confirmationDate))) ?></small>
                                        <?php endif; ?>
                                    
                                    <?php elseif ($sessionActive && $enabled === 1): ?>
                                        <form method="POST" action="<?= URL ?>inventoryassignment/confirm">
                                            <input type="hidden" name="assignment_id" value="<?= htmlspecialchars($assignment['id']) ?>">
                                            <button type="submit" class="btn btn-sm btn-success">Confirm</button>
                                        </form>
                                    
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-secondary" disabled>Confirm</button>
                                    <?php endif; ?>
                                </td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">You don't have any approved assigned items.</td>
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
        if (approvedTable) new simpleDatatables.DataTable(approvedTable);
    });
</script>

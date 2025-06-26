<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

<!-- Wizard Styles -->
<style>
    .wizard-steps-panel {
        position: relative;
        height: auto;
        text-align: center;
        margin-bottom: 25px;
        padding-top: 10px;
        padding-bottom: 10px;
    }

    .wizard-steps-panel .step-number {
        display: inline-block;
        margin: 0 15px;
        text-align: center;
    }

    .wizard-steps-panel .step-number .number {
        display: inline-block;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        line-height: 40px;
        font-size: 18px;
        background: #dedede;
        color: #000;
        font-weight: 500;
        transition: all 0.3s ease-in-out;
    }

    .wizard-steps-panel .doing .number {
        background: #0d6efd;
        color: #fff;
        box-shadow: 0 0 10px rgba(13, 110, 253, 0.4);
    }

    .wizard-steps-panel .done .number {
        background: #198754;
        color: #fff;
        box-shadow: 0 0 10px rgba(25, 135, 84, 0.4);
    }

    .wizard-step {
        display: none;
        padding: 15px 20px;
        border-radius: 8px;
        background-color: #f8f9fa;
        margin-bottom: 15px;
        transition: all 0.3s ease-in-out;
    }

    .wizard-step.active {
        display: block;
    }

    .wizard-buttons {
        display: flex;
        justify-content: space-between;
        padding: 15px 20px;
        border-top: 1px solid #dee2e6;
        background-color: #f8f9fa;
    }

    .wizard-buttons .btn {
        min-width: 100px;
    }

    .modal-body.wizard-content {
        padding: 20px 25px;
    }
    .wizard-content .active {
    color: inherit !important;
    background: none !important;
    text-decoration: none !important;
}

    .wizard-step .form-group {
        margin-top: 15px;
    }

    .wizard-step strong {
        display: block;
        margin-bottom: 10px;
        font-size: 16px;
    }
</style>


<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Returned Items</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
            <li class="breadcrumb-item">My Items</li>
            <li class="breadcrumb-item">Returned Assignments</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                This is a list of items you have returned. Those approved and those still pending.
            </div>
        </div>

        <!-- Returned Items -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-undo me-1"></i></span>                            
            </div>

            <div class="card-body table-responsive">
                <table id="returnedItemsTable">
                <thead>
                    <tr>
                        <th>Item Name</th>
                        <th>Serial Number</th>
                        <th>Tag Number</th>
                        <th>Received By</th>
                        <th>Return Date</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Disapproval Reason</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($returnedItems)): ?>
                    <?php foreach ($returnedItems as $return): ?>
                        <tr>
                            <td><?= htmlspecialchars($return['description']); ?></td>
                            <td><?= htmlspecialchars($return['serial_number']); ?></td>
                            <td><?= htmlspecialchars(isset($return['tag_number']) ? $return['tag_number'] : '') ?></td>
                            <td><?= htmlspecialchars($return['receiver_name']); ?></td>
                            <td><?= htmlspecialchars($return['return_date']); ?></td>
                            <td>
                                <?php
                                    $badgeClass = 'bg-warning text-dark';
                                    if ($return['status'] === 'approved') {
                                        $badgeClass = 'bg-success';
                                    } elseif ($return['status'] === 'disapproved') {
                                        $badgeClass = 'bg-danger';
                                    }
                                ?>
                                <span class="badge <?= $badgeClass; ?>">
                                    <?= ucfirst($return['status']); ?>
                                </span>
                            </td>
                            <td>
                            <?= isset($return['approved_date']) ? htmlspecialchars($return['approved_date']) : 'N/A'; ?>
                            </td>
                            <td>
                            <?= isset($return['disapproval_comment']) ? htmlspecialchars($return['disapproval_comment']) : 'N/A'; ?>
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
                        <td colspan="8" class="text-center">No returned items found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
            </table>
            </div>
        </div>
    </div>
</main>

<!-- SimpleDatatables Initialization -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const returnedTable = document.getElementById('returnedItemsTable');
        if (returnedTable) new simpleDatatables.DataTable(returnedTable);
    });
</script>
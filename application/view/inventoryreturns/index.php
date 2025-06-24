<link href="<?= URL ?>css/tables.css" rel="stylesheet">
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
        <h3 class="mt-4">Assigned Items</h3>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
            <li class="breadcrumb-item">My Items</li>
            <li class="breadcrumb-item">Assigned Assignments</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                This page displays a list of items assigned to you.
            </div>
        </div>

        <!-- Approved Assignments -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-check-circle me-1"></i></span>

                <!-- Wizard Trigger Button -->
                <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#wizardModal">
                    Record Return
                </button>
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
                            <th>Tag Number</th>
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
                                    <td><?= htmlspecialchars(isset($assignment['tag_number']) ? $assignment['tag_number'] : '') ?></td>
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

<!-- Modal Wizard -->
<div class="modal fade" id="wizardModal" tabindex="-1" aria-labelledby="wizardLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="wizardLabel">Return Items</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body wizard-content">
                <div class="wizard-steps-panel steps-quantity-3"></div>

                <?php if (!empty($approvedAssignments)): ?>
    <form action="<?= URL; ?>inventoryreturn/add" method="post">
        <!-- Step 1 -->
        <div class="wizard-step">
            <strong>Step 1: Select Items to Return</strong>
            <div class="form-group">
                <select name="assignment_ids[]" multiple class="form-control" required>
                    <?php foreach ($approvedAssignments as $item): ?>
                        <option value="<?= $item['id']; ?>">
                            <?= htmlspecialchars($item['description']); ?> (<?= htmlspecialchars($item['serial_number']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
                <small class="text-muted">Hold Ctrl/Cmd to select multiple items</small>
            </div>
        </div>

        <!-- Step 2 -->
        <div class="wizard-step">
            <strong>Step 2: Enter Return Date</strong>
            <div class="form-group">
                <input type="date" name="return_date" class="form-control" value="<?= date('Y-m-d'); ?>" max="<?= date('Y-m-d'); ?>" required>
            </div>
        </div>

        <!-- Step 3 -->
        <div class="wizard-step">
            <strong>Step 3: Select Receiver</strong>
            <div class="form-group">
                <select name="receiver_id" class="form-control" required>
                    <option value="">Select Receiver</option>
                    <?php foreach ($receivers as $receiver): ?>
                        <option value="<?= $receiver['id']; ?>"><?= htmlspecialchars($receiver['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div class="wizard-buttons">
            <button type="button" class="btn btn-secondary prev-step">Previous</button>
            <button type="button" class="btn btn-primary next-step">Next</button>
            <button type="submit" class="btn btn-success d-none finish-step">Submit</button>
        </div>
    </form>
    <?php else: ?>
        <p class="text-muted">No items available for return.</p>
    <?php endif; ?>

            </div>

        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const approvedTable = document.getElementById('approvedItemsTable');
        if (approvedTable) new simpleDatatables.DataTable(approvedTable);
    });
</script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
<script>
    const steps = document.querySelectorAll('.wizard-step');
    const nextBtns = document.querySelectorAll('.next-step');
    const prevBtns = document.querySelectorAll('.prev-step');
    const finishBtn = document.querySelector('.finish-step');

    let currentStep = 0;

    function showStep(index) {
        steps.forEach((step, i) => {
            step.classList.toggle('active', i === index);
        });

        finishBtn.classList.toggle('d-none', index !== steps.length - 1);
        nextBtns.forEach(btn => btn.style.display = index === steps.length - 1 ? 'none' : 'inline-block');
        prevBtns.forEach(btn => btn.style.display = index === 0 ? 'none' : 'inline-block');
    }

    nextBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep < steps.length - 1) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    prevBtns.forEach(btn => {
        btn.addEventListener('click', () => {
            if (currentStep > 0) {
                currentStep--;
                showStep(currentStep);
            }
        });
    });

    document.addEventListener('DOMContentLoaded', () => {
        showStep(currentStep);
    });
</script>

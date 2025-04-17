
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">


<!-- Wizard Styles -->
<style>
    .wizard-steps-panel {
        position: relative;
        height: 4em;
        text-align: center;
        margin-bottom: 20px;
    }
    .wizard-steps-panel .step-number {
        display: inline-block;
        font-size: 20px;
        margin: 0 10px;
    }
    .wizard-steps-panel .step-number .number {
        display: inline-block;
        width: 30px;
        height: 30px;
        border-radius: 50%;
        line-height: 30px;
        background: #dedede;
        color: #000;
    }
    .wizard-steps-panel .doing .number {
        background: #0d6efd;
        color: #fff;
    }
    .wizard-steps-panel .done .number {
        background: #198754;
        color: #fff;
    }
    .wizard-step {
        display: none;
    }
    .wizard-step.active {
        display: block;
    }
</style>

<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Returned Items</h3>
        <div class="card mb-4">
            <div class="card-body">
                This is a list of items you have returned. Those approved and those still pending.
            </div>
        </div>

        <!-- Returned Items -->
        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span><i class="fas fa-undo me-1"></i></span>

                <!-- Wizard Trigger Button -->
                <button type="button" class="add-btn" data-bs-toggle="modal" data-bs-target="#wizardModal">
                    Record Return 
                </button>
                            
            </div>

            <div class="card-body table-responsive">
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

                <?php if (!empty($items)): ?>
                <form action="<?= URL; ?>inventoryreturn/add" method="post">
                    <!-- Step 1 -->
                    <div class="wizard-step">
                        <strong>Step 1: Select Items to Return</strong>
                        <div class="form-group">
                            <select name="assignment_ids[]" multiple class="form-control" required>
                                <?php foreach ($items as $item): ?>
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
                            <input type="date" name="return_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                    </div>

                    <!-- Step 3 -->
                    <div class="wizard-step">
                        <strong>Step 3: Select Receiver</strong>
                        <div class="form-group">
                            <select name="receiver_id" class="form-control" required>
                                <option value="">Select Receiver</option>
                                <?php foreach ($receivers as $receiver): ?>
                                    <option value="<?= $receiver['id']; ?>">
                                        <?= htmlspecialchars($receiver['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <input type="hidden" name="status" value="pending">
                    </div>
                </form>
                <?php else: ?>
                    <p class="text-muted">No items available for return.</p>
                <?php endif; ?>
            </div>

            <div class="modal-footer wizard-buttons"></div>

        </div>
    </div>
</div>

</main>

<!-- SimpleDatatables Initialization -->
<script>
    window.addEventListener('DOMContentLoaded', () => {
        const returnedTable = document.getElementById('returnedItemsTable');
        if (returnedTable) new simpleDatatables.DataTable(returnedTable);
    });
</script>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        var container = document.querySelector(".wizard-content");
        if (!container) return;

        var steps = Array.from(container.querySelectorAll(".wizard-step"));
        var stepCount = steps.length;
        var current = 0;

        // Build step indicators
        var panel = container.querySelector(".wizard-steps-panel");
        for (var i = 0; i < stepCount; i++) {
            panel.innerHTML += '<div class="step-number step-' + i + '"><div class="number">' + (i + 1) + '</div></div>';
        }
        panel.querySelector('.step-0').classList.add('doing');

        // Create footer buttons
        var footer = document.querySelector(".wizard-buttons");
        footer.innerHTML = `
            <button type="button" class="btn btn-secondary btn-exit" data-bs-dismiss="modal">Exit</button>
            <button type="button" class="btn btn-secondary btn-back" style="display:none;">Back</button>
            <button type="button" class="btn btn-primary btn-next">Next</button>
            <button type="button" class="btn btn-success btn-finish" style="display:none;">Finish</button>
        `;

        var btnBack = footer.querySelector(".btn-back");
        var btnNext = footer.querySelector(".btn-next");
        var btnFinish = footer.querySelector(".btn-finish");

        function goToStep(index) {
            steps.forEach(function(step, idx) {
                step.classList.remove('active');
                panel.querySelector('.step-' + idx).classList.remove('doing');
                if (idx < index) {
                    panel.querySelector('.step-' + idx).classList.add('done');
                } else {
                    panel.querySelector('.step-' + idx).classList.remove('done');
                }
            });
            steps[index].classList.add('active');
            panel.querySelector('.step-' + index).classList.add('doing');
            btnBack.style.display = index > 0 ? 'inline-block' : 'none';
            btnNext.style.display = index < stepCount - 1 ? 'inline-block' : 'none';
            btnFinish.style.display = index === stepCount - 1 ? 'inline-block' : 'none';
        }

        btnNext.addEventListener("click", function () {
            if (current < stepCount - 1) {
                current++;
                goToStep(current);
            }
        });

        btnBack.addEventListener("click", function () {
            if (current > 0) {
                current--;
                goToStep(current);
            }
        });

        btnFinish.addEventListener("click", function () {
            container.querySelector("form").submit();
        });

        var wizardModalEl = document.getElementById("wizardModal");
        if (wizardModalEl) {
            wizardModalEl.addEventListener('hidden.bs.modal', function () {
                current = 0;
                goToStep(0);
            });
        }

        goToStep(current);
    });
</script>

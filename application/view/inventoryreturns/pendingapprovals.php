<!-- CSS Files -->
<link href="<?= htmlspecialchars(URL) ?>css/style.css" rel="stylesheet">
<link href="<?= htmlspecialchars(URL) ?>css/tables.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Pending Item Returns</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item">Collections</li>
        <li class="breadcrumb-item">Pending Item Returns</li>
    </ol>

    <div class="card mb-4">
        <div class="card-body">
            These are the returns awaiting your approval. You can approve and categorize the item condition.
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-undo me-1"></i>
        </div>
        <div class="card-body table-responsive">
            <table id="datatablesSimple">
                <thead>
                    <tr>
                        <th>Item Description</th>
                        <th>Serial Number</th>
                        <th>Returned By</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pendingApprovals)): ?>
                        <?php foreach ($pendingApprovals as $return): ?>
                            <tr>
                                <td><?= htmlspecialchars($return['description']) ?></td>
                                <td><?= htmlspecialchars($return['serial_number']) ?></td>
                                <td><?= htmlspecialchars($return['returned_by']) ?></td>
                                <td><?= htmlspecialchars($return['status']) ?></td>
                                <td>
                                    <form method="POST" action="<?= URL ?>inventoryreturn/approveReturn" class="d-flex flex-column gap-2">
                                        <input type="hidden" name="return_id" value="<?= $return['id'] ?>">

                                        <select name="item_state" class="form-select form-select-sm item-state-selector" required>
                                            <option value="">Select State</option>
                                            <option value="functional">Functional</option>
                                            <option value="damaged">Damaged</option>
                                            <option value="lost">Lost</option>
                                            <option value="disapproved">Disapproved</option>
                                        </select>

                                        <textarea name="disapproval_comment"
                                                  class="form-control form-control-sm mt-2 disapproval-comment"
                                                  placeholder="Enter disapproval reason..."
                                                  style="display:none;"></textarea>

                                        <button type="submit" class="btn btn-success btn-sm">Submit</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No pending approvals found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
</main>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<script>
    window.addEventListener('DOMContentLoaded', event => {
        const table = document.getElementById('datatablesSimple');
        if (table) {
            new simpleDatatables.DataTable(table);
        }
    });
</script>

<!-- Validation & Toggle Script -->
<script>
document.addEventListener('DOMContentLoaded', function () {
    const selectors = document.querySelectorAll('.item-state-selector');

    selectors.forEach(function (select) {
        select.addEventListener('change', function () {
            const form = this.closest('form');
            const textarea = form.querySelector('.disapproval-comment');

            if (this.value === 'disapproved') {
                textarea.style.display = 'block';
            } else {
                textarea.style.display = 'none';
                textarea.value = '';
            }
        });
    });

    // Validate disapproval comment on submit
    const forms = document.querySelectorAll('form');

    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const select = form.querySelector('.item-state-selector');
            const textarea = form.querySelector('.disapproval-comment');

            if (select && select.value === 'disapproved') {
                if (!textarea.value.trim()) {
                    e.preventDefault(); // prevent form submit
                    alert('Please provide a reason for disapproval.');
                    textarea.focus();
                }
            }
        });
    });
});
</script>

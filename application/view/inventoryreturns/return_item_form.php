<!-- Inline Styling and Bootstrap -->
<link href="<?= URL ?>css/style.css" rel="stylesheet">
<link href="<?= URL ?>css/tables.css" rel="stylesheet">

<style>
    .card-centered {
        max-width: 650px;
        margin: 30px auto;
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
        border-radius: 10px;
    }

    .card-header {
        font-weight: 600;
        font-size: 1.2rem;
    }

    .form-label {
        font-weight: 500;
    }

    button[type="submit"] {
        width: 100%;
    }

    @media (max-width: 768px) {
        .card-centered {
            margin: 20px 10px;
        }
    }
</style>

<main>
<div class="container-fluid px-4">
    <h3 class="mt-4">Return Items</h3>

    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="<?= URL ?>home">Home</a></li>
        <li class="breadcrumb-item"><a href="<?= URL ?>inventoryreturn">Returns</a></li>
        <li class="breadcrumb-item">Record Returns</li>
    </ol>

    <!-- Alert Handling -->
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($_GET['success']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Return Form -->
    <div class="card mb-4 card-centered">
        <div class="card-header">
            <i class="fas fa-undo me-1"></i>
            
        </div>
        <div class="card-body">
            <?php if (!empty($items)): ?>
                <form action="<?= URL ?>inventoryreturn/add" method="post">
                    <!-- Item Selection -->
                    <div class="mb-3">
                        <label class="form-label">Select Items to Return</label>
                        <select name="assignment_ids[]" multiple class="form-select" required>
                            <?php foreach ($items as $item): ?>
                                <option value="<?= $item['id']; ?>">
                                    <?= htmlspecialchars($item['description']); ?> (<?= htmlspecialchars($item['serial_number']); ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <small class="text-muted">Hold Ctrl/Cmd to select multiple items</small>
                    </div>

                    <!-- Return Date -->
                    <div class="mb-3">
                        <label class="form-label">Return Date</label>
                        <input type="date" name="return_date" class="form-control" value="<?= date('Y-m-d'); ?>" required>
                    </div>

                    <!-- Receiver -->
                    <div class="mb-3">
                        <label class="form-label">Select Receiver</label>
                        <select name="receiver_id" class="form-select" required>
                            <option value="">Select Receiver</option>
                            <?php foreach ($receivers as $receiver): ?>
                                <option value="<?= $receiver['id']; ?>">
                                    <?= htmlspecialchars($receiver['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <!-- Hidden Status -->
                    <input type="hidden" name="status" value="pending" readonly>

                    <!-- Submit -->
                    <button type="submit" class="btn btn-success">Record Return</button>
                </form>
            <?php else: ?>
                <p class="text-muted">No items available for return.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
</main>

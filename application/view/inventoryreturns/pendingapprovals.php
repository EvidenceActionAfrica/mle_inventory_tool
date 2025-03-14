<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Returns</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?= htmlspecialchars(URL) ?>css/tables.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2>Pending Item Returns</h2>
        
        <table>
        <thead>
                    <tr>
                        <th>Description</th>
                        <th>Serial Number</th>
                        <th>Returned By</th>
                        <th>Return Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pendingReturns)): ?>
                        <?php foreach ($pendingReturns as $return): ?>
                            <tr>
                                <td><?= htmlspecialchars($return['description']); ?></td>
                                <td><?= htmlspecialchars($return['serial_number']); ?></td>
                                <td><?= htmlspecialchars($return['returned_by']); ?></td>
                                <td><?= htmlspecialchars($return['return_date']); ?></td>
                                <td>
                                    <form method="POST" action="<?= URL ?>collections/approveReturn" class="d-flex align-items-center gap-2">
                                        <input type="hidden" name="return_id" value="<?= $return['id'] ?>">
                                        <input type="hidden" name="item_id" value="<?= $return['item_id'] ?>">

                                        <label for="item_state" class="visually-hidden">Item State:</label>
                                        <select name="item_state" class="form-select form-select-sm" required>
                                            <option value="functional">Functional</option>
                                            <option value="damaged">Damaged</option>
                                            <option value="lost">Lost</option>
                                        </select>

                                        <button type="submit" class="btn btn-success btn-sm">Approve</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">No pending returns found.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

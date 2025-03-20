<link href="<?= htmlspecialchars(URL) ?>css/tables.css" rel="stylesheet">
    <div class="container mt-5">
        <h2>Pending Item Returns</h2>
        <table>
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
                                <form method="POST" action="<?= URL ?>inventoryreturn/approveReturn">
                                    <input type="hidden" name="return_id" value="<?= $return['id'] ?>">                                  
                                    <label for="item_state">Item State:</label>
                                    <select name="item_state" required>
                                        <option value="functional">Functional</option>
                                        <option value="damaged">Damaged</option>
                                        <option value="lost">Lost</option>
                                    </select>

                                    <button type="submit">Approve</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No pending approvals found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

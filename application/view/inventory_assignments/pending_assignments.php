<link rel="stylesheet" href="<?php echo URL; ?>css/tables.css">
<link rel="stylesheet" href="<?php echo URL; ?>css/style.css">


<div >
    <h2>Pending Assignments</h2>

    <?php if (!empty($_GET['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_GET['success']); ?></div>
    <?php endif; ?>

    <?php if (!empty($_GET['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_GET['error']); ?></div>
    <?php endif; ?>

    <table>
        <thead>
            <tr>
                <th>User Name</th>
                <th>Email</th>
                <th>Description</th>
                <th>Serial Number</th>
                <th>Date Assigned</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($pendingAssignments)): ?>
                <?php foreach ($pendingAssignments as $assignment): ?>
                    <tr>
                        <td><?= htmlspecialchars($assignment['user_name']); ?></td>
                        <td><?= htmlspecialchars($assignment['email']); ?></td>
                        <td><?= htmlspecialchars($assignment['description']); ?></td>
                        <td><?= htmlspecialchars($assignment['serial_number']); ?></td>
                        <td><?= htmlspecialchars($assignment['date_assigned']); ?></td>
                        <td>
                        <form action="<?= URL ?>inventoryassignment/acknowledge" method="POST">
    <input type="hidden" name="assignment_id" value="<?= $assignment['id'] ?>">
    <button type="submit" class="btn btn-success">Acknowledge</button>
</form>


                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No pending assignments found.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

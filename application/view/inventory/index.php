<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
<link href="<?php echo URL; ?>css/tables.css" rel="stylesheet">

<main>
    <div class="container-fluid px-4">
        <h3 class="mt-4">Inventory List</h3>

        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="<?php echo URL; ?>home">Home</a></li>
            <li class="breadcrumb-item">Configurations</li>
            <li class="breadcrumb-item">Inventory</li>
        </ol>
        <div class="card mb-4">
            <div class="card-body">
                This is a collection of all the assets in the organisation and their details.
            </div>
        </div>
        <!-- success/error message -->
        <?php if (isset($_GET['update']) && isset($_GET['message'])): ?>
            <?php
                // Set background color based on 'update' value
                $bgColor = $_GET['update'] === 'success' ? 'green' : 'red';
                $textColor = 'white'; // White text for better contrast
            ?>
            <div id="messageDiv" style="background-color: <?= $bgColor; ?>; color: <?= $textColor; ?>; padding: 10px; text-align: center;">
                <?= htmlspecialchars(urldecode($_GET['message'])); ?>
            </div>

            <!-- JavaScript to hide the message after 3 seconds -->
            <script>
                // Wait for the DOM to be fully loaded
                document.addEventListener('DOMContentLoaded', function() {
                    // Set a timeout to hide the message after 3 seconds (3000ms)
                    setTimeout(function() {
                        const messageDiv = document.getElementById('messageDiv');
                        if (messageDiv) {
                            messageDiv.style.display = 'none'; // Hide the message
                        }
                    }, 10000);
                });
            </script>
        <?php endif; ?>

     
        <!-- Card for inventory list -->
        <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="fas fa-table me-1"></i></span>
            <div class="d-flex gap-2">
                <!-- Download Template Icon Button -->
                <a href="<?= URL; ?>inventory/downloadInventoryTemplate" 
                class="btn btn-sm text-white" 
                style="background-color: #05545a;">
                <i class="fas fa-download"></i>
                </a>

                <!-- Upload CSV Button -->
                <form action="<?= URL; ?>inventory/bulkUpdate" method="POST" enctype="multipart/form-data" class="mb-0 d-flex align-items-center gap-2">
                    <input type="file" name="bulk_file" accept=".csv" required class="form-control form-control-sm" style="max-width: 200px;" />
                    <button type="submit" class="add-btn" style="background-color: #05545a; border-color: #05545a;">
                        Upload CSV
                    </button>
                </form>

                <!-- Add New Item Button -->
                <form method="GET" action="<?= URL ?>inventory/add" class="mb-0">
                    <button type="submit" class="add-btn">
                        Add New Item
                    </button>
                </form>
            </div>
        </div>

            <div class="card-body table-responsive">
                <!-- Inventory Table -->
                <table id="datatablesSimple">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Description</th>
                            <th>Serial Number</th>
                            <th>Tag Number</th>
                            <th>Acquisition Date</th>
                            <th>Acquisition Cost ($)</th>
                            <th>Warranty Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($items)): ?>
                            <?php foreach ($items as $item): ?>
                                <tr>
                                <td><?= htmlspecialchars($item['category'] ?? 'N/A'); ?></td>
                                <td><?= htmlspecialchars($item['description'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($item['serial_number'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($item['tag_number'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($item['acquisition_date'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($item['acquisition_cost'] ?? ''); ?></td>
                                <td><?= htmlspecialchars($item['warranty_date'] ?? ''); ?></td>

                                    <td class="d-flex justify-content-between">
                                        <!-- Edit Button -->
                                        <a href="<?= URL ?>inventory/edit/<?= htmlspecialchars($item['id'] ?? ''); ?>" 
                                           class="btn btn-sm btn-outline-primary me-1">Edit</a>

                                        <!-- Delete Button -->
                                        <form action="<?= URL ?>inventory/delete" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this item?');" 
                                              style="display:inline;">
                                            <input type="hidden" name="id" value="<?= htmlspecialchars($item['id'] ?? ''); ?>">
                                            <button type="submit" name="delete" class="btn btn-sm btn-outline-danger me-1">Delete</button>
                                        </form>

                                        <!-- Assign Button (Modal Trigger) -->
                                        <button type="button" class="btn btn-sm btn-outline-success" data-bs-toggle="modal" data-bs-target="#assignModal" data-item-id="<?= htmlspecialchars($item['id'] ?? ''); ?>">Assign</button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="8" class="text-center">No items found.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal for Item Assignment -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Assign Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" action="<?= URL ?>inventory/assignSingle">
                        <input type="hidden" name="item_id" id="item_id">

                        <!-- Dropdown for User -->
                        <div class="mb-3">
                            <label for="user_id" class="form-label">User</label>
                            <select class="form-control" name="user_id" required>
                                <option value="">Select User</option>
                                <?php foreach ($users as $user): ?>
                                    <option value="<?= htmlspecialchars($user['id']); ?>">
                                        <?= htmlspecialchars(strtok($user['email'], '@')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Dropdown for Manager Email -->
                        <div class="mb-3">
                            <label for="manager_email" class="form-label">Manager</label>
                            <select class="form-control" name="manager_email" required>
                                <option value="">Select Manager</option>
                                <?php foreach ($managers as $manager): ?>
                                    <option value="<?= htmlspecialchars($manager['email']); ?>">
                                        <?= htmlspecialchars(strtok($manager['email'], '@')); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Date Assigned -->
                        <div class="mb-3">
                            <label for="date_assigned" class="form-label">Date Assigned</label>
                            <input type="date" class="form-control" name="date_assigned" value="<?= date('Y-m-d'); ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Assign Item</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
        </div>
    </div>
</main>
<script>
    window.addEventListener('DOMContentLoaded', () => {
        // Simple DataTable initialization
        const datatable = document.getElementById('datatablesSimple');
        if (datatable) {
            new simpleDatatables.DataTable(datatable);
        }

        // Assign Modal - set item ID
        const assignButtons = document.querySelectorAll('[data-bs-toggle="modal"]');
        assignButtons.forEach(button => {
            button.addEventListener('click', function () {
                const itemId = this.getAttribute('data-item-id');
                document.getElementById('item_id').value = itemId;
            });
        });


    });
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


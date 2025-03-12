<h2>Inventory List</h2>

    <!-- Flash Messages -->
    <?php if (isset($_GET['success'])): ?>
        <p class="success-message"><?= htmlspecialchars($_GET['success']); ?></p>
    <?php elseif (isset($_GET['error'])): ?>
        <p class="error-message"><?= htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>

    <!-- Top Bar -->
    <div class="top-bar">
        <form method="GET" action="<?= URL ?>inventory/search" class="search-form">
        <input type="text" name="search" placeholder="Search by Tag, Serial Number, or Description" 
            value="<?= htmlspecialchars($search_query); ?>" required>
        <button type="submit" aria-label="Search for inventory items">Search</button>
        <?php if (!empty($search_query)): ?>
            <a href="<?= URL ?>inventory" class="reset-search">Reset</a>
        <?php endif; ?>
    </form>

        <form action="<?= URL ?>inventory/add" method="GET">
            <button type="submit" class="add-btn">Add New Item</button>
        </form>


    </div>

    <!-- Inventory Table -->
    <table>
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
                        <td><?= htmlspecialchars($item['category'] ?? "N/A"); ?></td>
                        <td><?= htmlspecialchars($item['description']); ?></td>
                        <td><?= htmlspecialchars($item['serial_number']); ?></td>
                        <td><?= htmlspecialchars($item['tag_number']); ?></td>
                        <td><?= htmlspecialchars($item['acquisition_date']); ?></td>
                        <td><?= htmlspecialchars($item['acquisition_cost']); ?></td>
                        <td><?= htmlspecialchars($item['warranty_date']); ?></td>
                        <td>
                        <a href="<?= URL ?>inventory/edit?id=<?= htmlspecialchars($item['id']); ?>">Edit</a> |
                            <form action="<?= URL ?>inventory/delete" method="POST" 
                                onsubmit="return confirm('Are you sure you want to delete this item?');" style="display:inline;">
                                <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']); ?>">
                                <button type="submit" name="delete" class="delete-btn">Delete</button>
                            </form>

                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">Oop!! yooh Not Found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

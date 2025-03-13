<link href="<?= htmlspecialchars(URL) ?>css/tables.css" rel="stylesheet">
<script>
        document.addEventListener("DOMContentLoaded", function() {
            populateCategory();
        });

        function populateCategory() {
        let descriptionSelect = document.getElementById("description");
        let categoryField = document.getElementById("category");
        let categoryIdField = document.getElementById("category_id");

        let selectedOption = descriptionSelect.options[descriptionSelect.selectedIndex];
        categoryField.value = selectedOption.getAttribute("data-category"); // Sets category name
        categoryIdField.value = selectedOption.getAttribute("data-category-id"); // Sets category_id
    }


        function validateDate() {
            let acquisitionDate = document.getElementById("acquisition_date").value;
            let today = new Date().toISOString().split("T")[0];

            if (acquisitionDate > today) {
                alert("Acquisition date cannot be in the future!");
                document.getElementById("acquisition_date").value = "";
            }
        }
    </script>
    <div class="form-container">
        <h2>Edit Inventory Item</h2>
        <form action="<?= URL ?>inventory/edit/<?= htmlspecialchars($item['id']); ?>" method="POST">
            <input type="hidden" name="id" value="<?= htmlspecialchars($item['id']) ?>">

            <div class="form-group">
                <!-- Description dropdown -->
            <div class="form-group">
                <label for="description">Description:</label>
                <select name="description" id="description" required onchange="populateCategory()">
                    <option value="">Select Description</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['description']) ?>" 
                                data-category="<?= htmlspecialchars($category['category']) ?>" 
                                data-category-id="<?= htmlspecialchars($category['id']) ?>"
                                <?= $item['description'] == $category['description'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($category['description']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Category name (readonly) -->
            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" id="category" value="<?= htmlspecialchars($descriptionToCategory[$item['description']] ?? '') ?>" readonly>
                <input type="hidden" name="category_id" id="category_id" value="<?= htmlspecialchars($item['category_id']) ?>">
            </div>



            <div class="form-group">
                <label for="serial_number">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" value="<?= htmlspecialchars($item['serial_number']) ?>" required>
            </div>

            <div class="form-group">
                <label for="tag_number">Tag Number:</label>
                <input type="text" id="tag_number" name="tag_number" value="<?= htmlspecialchars($item['tag_number']) ?>" required>
            </div>

            <div class="form-group">
                <label for="acquisition_date">Acquisition Date:</label>
                <input type="date" id="acquisition_date" name="acquisition_date" value="<?= htmlspecialchars($item['acquisition_date']) ?>" required onchange="validateDate()">
            </div>

            <div class="form-group">
                <label for="acquisition_cost">Acquisition Cost ($):</label>
                <input type="number" id="acquisition_cost" name="acquisition_cost" step="0.01" value="<?= htmlspecialchars($item['acquisition_cost']) ?>" required>
            </div>

            <div class="form-group">
                <label for="warranty_date">Warranty Expiration Date:</label>
                <input type="date" id="warranty_date" name="warranty_date" value="<?= htmlspecialchars($item['warranty_date']) ?>" required>
            </div>

            <button type="submit" name="update" class="submit-btn">Update Item</button>
        </form>
    </div>


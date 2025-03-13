<link href="<?= htmlspecialchars(URL) ?>css/tables.css" rel="stylesheet">
    <div class="form-container">
        <h2>Add New Inventory Item</h2>

        <form action="<?= htmlspecialchars(URL . 'inventory/add') ?>" method="POST">
            <div class="form-group">
                <label for="description">Description:</label>
                <select name="category_id" id="description" required onchange="populateCategory()">
                    <option value="">Select Description</option>
                    <?php foreach ($categories as $category): ?>
                        <option value="<?= htmlspecialchars($category['id']) ?>" 
                                data-description="<?= htmlspecialchars($category['description']) ?>" 
                                data-category="<?= htmlspecialchars($category['category']) ?>">
                            <?= htmlspecialchars($category['description']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" id="description_text" name="description">

            <div class="form-group">
                <label for="category">Category:</label>
                <input type="text" name="category" id="category" readonly>
            </div>

            <div class="form-group">
                <label for="serial_number">Serial Number:</label>
                <input type="text" id="serial_number" name="serial_number" required>
            </div>

            <div class="form-group">
                <label for="tag_number">Tag Number:</label>
                <input type="text" id="tag_number" name="tag_number" required>
            </div>

            <div class="form-group">
                <label for="acquisition_date">Acquisition Date:</label>
                <input type="date" id="acquisition_date" name="acquisition_date" required onchange="validateDate()">
            </div>

            <div class="form-group">
                <label for="acquisition_cost">Acquisition Cost ($):</label>
                <input type="number" id="acquisition_cost" name="acquisition_cost" step="0.01" required>
            </div>

            <div class="form-group">
                <label for="warranty_date">Warranty Expiration Date:</label>
                <input type="date" id="warranty_date" name="warranty_date" required>
            </div>

            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </div>

    <script>
        function populateCategory() {
            let descriptionSelect = document.getElementById("description");
            let selectedOption = descriptionSelect.options[descriptionSelect.selectedIndex];
            document.getElementById("description_text").value = selectedOption.getAttribute("data-description");
            document.getElementById("category").value = selectedOption.getAttribute("data-category");
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

<?php

class Inventory extends Controller
{
    // Fetch all inventory items
    public function index()
    {
        $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
        $items = !empty($search_query) ? $this->model->searchItems($search_query) : $this->model->getItems();

        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/index.php';
    }

    // Add a new item
    public function add()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process form submission
            $category_id = intval($_POST['category_id']);
            $description = trim($_POST['description']);
            $serial_number = trim($_POST['serial_number']);
            $tag_number = trim($_POST['tag_number']);
            $acquisition_date = trim($_POST['acquisition_date']);
            $acquisition_cost = trim($_POST['acquisition_cost']);
            $warranty_date = trim($_POST['warranty_date']);

            $this->model->addItem($category_id, $description, $serial_number, $tag_number, $acquisition_date, $acquisition_cost, $warranty_date);
            header("Location: " . URL . "inventory/index?success=Item added successfully!");
            exit();
        } else {
            // Display the add item form
            $categories = $this->model->getCategories() ?? [];
            require APP . 'view/_templates/header.php';
            require APP . 'view/inventory/add_inventory_item.php';
        }
    }


    // Edit an existing item
    public function edit($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Handle form submission
            $id = intval($_POST['id']);
            $category_id = intval($_POST['category_id']);
            $description = trim($_POST['description']);
            $serial_number = trim($_POST['serial_number']);
            $tag_number = trim($_POST['tag_number']);
            $acquisition_date = trim($_POST['acquisition_date']);
            $acquisition_cost = trim($_POST['acquisition_cost']);
            $warranty_date = trim($_POST['warranty_date']);
    
            // Update item in the database
            $this->model->updateItem($id, $category_id, $description, $serial_number, $tag_number, $acquisition_date, $acquisition_cost, $warranty_date);
            header("Location: " . URL . "inventory/index?success=Item updated successfully!");
            exit();
        } else {
            // Fetch item data by ID for pre-filling the form
            $item = $this->model->getItemById($id);
            $categories = $this->model->getCategories() ?? [];
    
            require APP . 'view/_templates/header.php';
            require APP . 'view/inventory/edit_inventory_item.php';
        }
    }
    

    // Delete an item
    public function delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
            $id = intval($_POST['id']);
            $this->model->deleteItem($id);
            header("Location: " . URL . "inventory/index?success=Item deleted successfully!");
            exit();
        } else {
            header("Location: " . URL . "inventory/index?error=Invalid delete request.");
            exit();
        }
    }


    // Search inventory items
    public function search()
    {
        $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
        $items = $this->model->searchItems($search_query);

        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/index.php';
    }


}

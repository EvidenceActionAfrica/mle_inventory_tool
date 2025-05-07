<?php

class Inventory extends Controller
{
    // Fetch all inventory items
    public function index()
    {
        session_start();
    
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
    
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
    
        $search_query = isset($_GET['search']) ? trim($_GET['search']) : '';
        $items = !empty($search_query) ? $this->model->searchItems($search_query) : $this->model->getItems();
    
        // Fetch users and managers for dropdowns
        $users = $this->model->getAllUsers();  
        $managers = $this->model->getManagers();  
    
    
        // Fetch users and managers for dropdowns
        $users = $this->model->getAllUsers();  
        $managers = $this->model->getManagers();  
    
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/index.php';
    }
    
    

    // Add a new item
    public function add()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        session_start();
    
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
            $categories = $this->model->getCategories() ?? [];
            require APP . 'view/_templates/sessions.php';
            require APP . 'view/_templates/header.php';
            require APP . 'view/inventory/add_inventory_item.php';
        }
    }


    // Edit an existing item
    public function edit($id)
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        session_start();
    
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = intval($_POST['id']);
            $category_id = intval($_POST['category_id']);
            $description = trim($_POST['description']);
            $serial_number = trim($_POST['serial_number']);
            $tag_number = trim($_POST['tag_number']);
            $acquisition_date = trim($_POST['acquisition_date']);
            $acquisition_cost = trim($_POST['acquisition_cost']);
            $warranty_date = trim($_POST['warranty_date']);
    
            $this->model->updateItem($id, $category_id, $description, $serial_number, $tag_number, $acquisition_date, $acquisition_cost, $warranty_date);
            header("Location: " . URL . "inventory/index?success=Item updated successfully!");
            exit();
        } else {

            $item = $this->model->getItemById($id);
            $categories = $this->model->getCategories() ?? [];
            require APP . 'view/_templates/sessions.php';
            require APP . 'view/_templates/header.php';
            require APP . 'view/inventory/edit_inventory_item.php';
        }
    }
    

    // Delete an item
    public function delete()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        session_start();
    
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
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


    //single item assigning
    public function assignSingle()
    {
        
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        session_start();
    
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = intval($_POST['user_id']);
            $item_id = intval($_POST['item_id']); 
            $date_assigned = $_POST['date_assigned'];
            $manager_email = $_POST['manager_email'];

            $result = $this->model->assignSingleItem($user_id, $item_id, $date_assigned, $manager_email);

            if (strpos($result, 'successfully') !== false) {
                header("Location: " . URL . "inventory/index?success=" . urlencode($result));
            } else {
                header("Location: " . URL . "inventory/index?error=" . urlencode($result));
            }
            exit();
        }
    }

    //bulk uploading
    public function bulkUpdate()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
    
        session_start(); 
    
        // Check if user is logged in
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
    
        if (isset($_FILES['bulk_file']) && $_FILES['bulk_file']['error'] == 0) {
            $file = $_FILES['bulk_file']['tmp_name'];
            $items = [];
    
            if (($handle = fopen($file, "r")) !== FALSE) {
                // Skip the first 7 rows (header + 6 example rows)
                for ($i = 0; $i < 8; $i++) {
                    fgetcsv($handle); // Skip each row
                }
    
                // Process the CSV data from the 8th row onwards
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    // Get category ID from the category name provided in the CSV
                    $category_name = trim($data[0]);  // Assuming category name is in the second column
                    $category_id = $this->model->getCategoryIdByName($category_name);
    
                    if ($category_id !== null) {
                        // If the category exists, store the item data
                        $items[] = [
                            'category_id' => $category_id,
                            'description' => trim($data[1]),
                            'serial_number' => trim($data[2]),
                            'tag_number' => trim($data[3]),
                            'acquisition_date' => trim($data[4]),
                            'acquisition_cost' => trim($data[5]),
                            'warranty_date' => isset($data[6]) ? trim($data[6]) : null,
                        ];                        
                    } else {
                        // Optionally handle the case where the category doesn't exist
                        // For now, just skip that row
                        continue;
                    }
                }
    
                fclose($handle);
            }
            // echo '<pre>'; print_r($items); 
            // Bulk update items using the model
            if (!empty($items)) {
                $this->model->bulkInsertItems($items);
                header('Location: ' . URL . 'inventory/index?update=success');
            } else {
                header('Location: ' . URL . 'inventory/index?update=fail');
            }
        } else {
            header('Location: ' . URL . 'inventory/index?update=fail');
        }
    }
    
}

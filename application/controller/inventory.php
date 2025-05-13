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
    
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
    
        if (isset($_FILES['bulk_file']) && $_FILES['bulk_file']['error'] == 0) {
            $file = $_FILES['bulk_file']['tmp_name'];
            $itemsToInsert = [];
            $errors = [];
            $successCount = 0;
    
            if (($handle = fopen($file, "r")) !== FALSE) {
                // Skip the first 10 rows
                for ($i = 0; $i < 10; $i++) {
                    fgetcsv($handle);
                }
    
                $rowNumber = 11; // Start at 11 because first 10 rows are skipped
    
                while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                    $rowErrors = [];
    
                    $category_name = trim($data[0] ?? '');
                    $description = trim($data[1] ?? '');
                    $serial_number = trim($data[2] ?? '');
                    $tag_number = !empty(trim($data[3] ?? '')) ? trim($data[3]) : null;
                    $acquisition_date = trim($data[4] ?? '');
                    $acquisition_cost = trim($data[5] ?? '');
                    $warranty_date = isset($data[6]) ? trim($data[6]) : null;
    
                    // Validate fields
                    if (empty($category_name)) {
                        $rowErrors[] = "Missing category name";
                    } else {
                        $category_id = $this->model->getCategoryIdByName($category_name);
                        if ($category_id === null) {
                            $rowErrors[] = "Invalid category: $category_name";
                        }
                    }
    
                    if (empty($description)) $rowErrors[] = "Missing description";
                    if (empty($serial_number)) {
                        $rowErrors[] = "Missing serial number";
                    } else if ($this->model->isSerialNumberExists($serial_number)) {
                        $rowErrors[] = "Duplicate serial number: $serial_number";
                    }
    
                    if (empty($acquisition_date)) $rowErrors[] = "Missing acquisition date";
                    if (empty($acquisition_cost)) $rowErrors[] = "Missing acquisition cost";
    
                    if (empty($rowErrors)) {
                        $itemsToInsert[] = [
                            'category_id' => $category_id,
                            'description' => $description,
                            'serial_number' => $serial_number,
                            'tag_number' => $tag_number,
                            'acquisition_date' => $acquisition_date,
                            'acquisition_cost' => $acquisition_cost,
                            'warranty_date' => $warranty_date,
                        ];
                        $successCount++;
                    } else {
                        $errors[] = "Row $rowNumber: " . implode(", ", $rowErrors);
                    }
    
                    $rowNumber++;
                }
    
                fclose($handle);
            }
    
            // Insert valid items
            if (!empty($itemsToInsert)) {
                $this->model->bulkInsertItems($itemsToInsert);
            }
    
            // Create feedback message
            $message = "$successCount items uploaded successfully.";
            if (!empty($errors)) {
                $message .= " " . count($errors) . " items failed: " . implode(" | ", $errors);
            }
           
            $updateStatus = $successCount > 0 ? 'success' : 'fail';
    
            header('Location: ' . URL . 'inventory/index?' . http_build_query([
                'update' => $updateStatus,
                'message' => $message
            ]));
    
        } else {
            $message = 'Error with the uploaded file.';
            header('Location: ' . URL . 'inventory/index?' . http_build_query([
                'update' => 'fail',
                'message' => $message
            ]));
        }
    
        exit();
    }
    
    
    
    //download inventory templte
    public function downloadInventoryTemplate()
    {
        $filename = "inventory_template.csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Header row
        fputcsv($output, ['category', 'description', 'serial_number', 'tag_number', 'acquisition_date', 'acquisition_cost', 'warranty_date']);

        // Static sample rows (7)
        fputcsv($output, ['Mouse', 'hp', 'sn100', 'tag-001', '2025-03-05', '20.00', '2025-03-08']);
        fputcsv($output, ['Laptop', 'Macbook', '4t5rfr5', 'tg-003', '2025-03-03', '100.00', '2025-04-24']);
        fputcsv($output, ['Printer', 'Laser Printers', '234ede4', 'ea-111', '2025-03-14', '123.00', '2025-05-01']);
        fputcsv($output, ['Smart Phone', 'Samsung A52', '1q234', '1q2ws', '2025-03-14', '125.00', '2025-04-30']);
        fputcsv($output, ['Monitor', 'Asus ROG', 'r71083', 'ea-k011', '2025-04-01', '123.00', '2028-10-25']);
        fputcsv($output, ['CPU', 'Intel', 't5t5', 'rd4w3', '2025-05-05', '23390.00', '2025-06-20']);

        // Instruction row
        fputcsv($output, ['// - Kindly follow the naming convention above, especially for the category.']);
        fputcsv($output, ['// - Use yyyy-mm-dd format for all dates (e.g., 2025-03-05), and ensure acquisition_cost is a number with 2 decimal places (e.g., 123.00).']);
        fputcsv($output, ['// - NB: Do not alter anything in the header or example rows.']);
        

        fclose($output);
        exit();
    }

}

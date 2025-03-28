<?php

class inventoryreturn extends Controller
{

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
    
        $user_email = $_SESSION['user_email']; 
        $returned_by = $_SESSION['user_email']; // Adjust to match your session variable for the logged-in user's email
        $returnedItems = $this->model->getReturnedItems($returned_by);
        $approvedAssignments = $this->model->getApprovedAssignmentsByLoggedInUser($user_email);
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventoryreturns/index.php';
    }
    
    public function add()
    {
        session_start();
    
        if ($this->model === null) {
            die("Model not loaded properly!");
        }
    
        if (!isset($_SESSION['user_email'])) {
            die("User not logged in!");
        }
    
        $user_email = $_SESSION['user_email'];
        $returned_by = strstr($user_email, '@', true);
    
        $items = $this->model->getApprovedAssignmentsByLoggedInUser($user_email);
        $receivers = $this->model->getReceivers();
    
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            require APP . 'view/_templates/header.php';
            require APP . 'view/inventoryreturns/return_item_form.php';
            exit();
        }
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            echo "POST request received! Processing form submission...<br>";
        
            // Ensure `assignment_ids[]` is passed correctly
            $assignment_ids = $_POST['assignment_ids'] ?? [];
            $return_date = $_POST['return_date'] ?? date('Y-m-d H:i:s');  // Fallback to current date if not provided
            $receiver_id = $_POST['receiver_id'] ?? null;
            $returned_by = $_SESSION['user_email']; // or another logic to set who is returning the item
        
            if (empty($assignment_ids)) {
                die("No Assignment IDs selected!");
            }
        
            echo "Processing " . count($assignment_ids) . " item(s)...<br>";
        
            // Loop through each selected assignment_id
            foreach ($assignment_ids as $assignment_id) {
                echo "Processing Assignment ID: $assignment_id<br>"; // Debugging to ensure assignment_id is passed
        
                // Call the model method to record the return for each assignment
                $result = $this->model->recordReturn($assignment_id, $returned_by, $receiver_id, $return_date);
        
                if (!$result) {
                    echo "Failed to return Assignment ID: $assignment_id <br>";
                } else {
                    echo "Successfully returned Assignment ID: $assignment_id<br>";
                }
            }
        
            // Redirect after processing
            header("Location: " . URL . "inventoryReturn?success=Items returned successfully!");
            exit();
        }
    }        
    public function delete()
    {
        session_start();
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
    
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            header("Location: " . URL . "inventoryReturn?error=Invalid request!");
            exit();
        }
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        $id = $_GET['id'];
        $deleted = $this->model->deleteReturn($id);
    
        if ($deleted) {
            header("Location: " . URL . "inventoryReturn?success=Item deleted successfully!");
        } else {
            header("Location: " . URL . "inventoryReturn?error=Cannot delete approved returned items!");
        }
        exit();
    }
    
    //admins approving returns(fetch items to approve)
    public function approve()
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
    
        $user_email = $_SESSION['user_email'] ?? '';  
        $user_name = explode('@', $user_email)[0]; 
        $receivers = $this->model->getReceivers();
    
        $receiver_id = null;
        foreach ($receivers as $receiver) {
            if (strtolower($receiver['name']) === strtolower($user_name)) { 
                $receiver_id = $receiver['id'];
                break;
            }
        }
    
        $pendingApprovals = $this->model->getPendingApprovalsByUser($receiver_id);

        // Load the view
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventoryreturns/pendingapprovals.php';
    }
    
    //approve returned item
    public function approveReturn() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            session_start();

            if (!isset($_SESSION['user_email'])) {
                die("Unauthorized access.");
            }
            if ($this->model === null) {
                echo "Model not loaded properly!";
                exit();
            }
    
            $return_id  = $_POST['return_id'];
            $item_state = $_POST['item_state'];
            $approved_by = $_SESSION['user_id']; 
    
            if ($this->model->approveReturn($return_id, $item_state, $approved_by)) {
                $_SESSION['success'] = "Item return approved successfully!";

                if ($item_state === 'lost') {

                    header("Location: " . URL . "inventoryreturn/lostItems");
                } elseif ($item_state === 'damaged') {

                    header("Location: " . URL . "inventoryreturn/damagedItems");
                } else { 

                    header("Location: " . URL . "inventoryreturn/unassignedItems");
                }
                exit;
            } else {
                $_SESSION['error'] = "Failed to approve item return.";
                header("Location: " . URL . "inventoryreturn/approve");
                exit;
            }
        }
    }
        
    //item classifications....
    public function lostItems() 
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
        $lostItems = $this->model->getLostItems();
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/items_lost.php';
    }
    //searh i n lost items
    public function lostItemsSearch()
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

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $lostItems = $this->model->getLostItemsSearch($search);
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/items_lost.php';
    }

    public function damagedItems()
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
        $damagedItems = $this->model->getDamagedItems();
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/items_damaged.php';
    }
    //search damaged items
    public function searchDamagedItems()
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

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $damagedItems = $this->model->getDamagedItemsSearch($search);
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/items_damaged.php'; 
    }

    public function updateRepairStatus()    
    {
        session_start();
    
        if ($this->model === null) {
            die("Model not loaded properly!");
        }
    
        if (!isset($_SESSION['user_email'])) {
            die("User not logged in!");
        }
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $item_id = $_POST['item_id'] ?? null; 
            $repair_status = $_POST['repair_status'] ?? null;
        
            if (!$item_id || !$repair_status) {
                die("Missing required fields! Item ID: " . ($item_id ?? 'N/A') . " | Repair Status: " . ($repair_status ?? 'N/A'));
            }
        
            $result = $this->model->updateRepairStatus($item_id, $repair_status);
        
            if (!$result) {
                $_SESSION['error'] = "Failed to update repair status. Check if item exists.";
            } else {
                $_SESSION['success'] = "Repair status updated successfully!";
            }
        
            header("Location: " . URL . "inventoryreturn/damagedItems");
            exit();
        }        
    }
    
    public function unassignedItems()
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
        $unassignedItems = $this->model->getUnassignedItems();
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/items_instock.php';
    }
    //search unassihnmed
    public function searchUnassignedItems()
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
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    
        if (!empty($search)) {
            $unassignedItems = $this->model->getUnassignedItemsSearch($search);
        } else {
            $unassignedItems = $this->model->getUnassignedItems();
        }
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/items_instock.php';
    }
   
    public function assignedItems()
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
        $assignedItems = $this->model->getAssignedItems();
        if (isset($_GET['search'])) {
            $search = trim($_GET['search']);
        } 
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/inventory_inuse.php';
    }
    //search assigned items
    public function searchAssignedItems()
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
        if (isset($_GET['search'])) {
            $search = trim($_GET['search']);
            $assignedItems = $this->model->getAssignedItemsSearch($search);
            require APP . 'view/_templates/sessions.php';
            require APP . 'view/_templates/header.php';
            require APP . 'view/inventory/inventory_inuse.php';
        } else {
            header("Location: " . URL . "inventoryreturn/assignedItems");
            exit();
        }
    }
    
    public function disposedItems()
    {
        session_start();

        if (!isset($_SESSION['user_email'])) { 
            die("User not logged in!");
        }
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }

        // Fetch disposed items
        $disposedItems = $this->model->getDisposedItems();
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/items_disposed.php';
    }
    //search disposred items
    public function searchDisposedItems()
    {
        session_start();

        if (!isset($_SESSION['user_email'])) { 
            die("User not logged in!");
        }

        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }

        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $disposedItems = $this->model->getDisposedItemsSearch($search);
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/items_disposed.php'; 
    }
    
    //managers reports
    //returned items for staff
    public function staffreturneditems()
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

        $loggedInEmail = $_SESSION['user_email'];
        $search = isset($_GET['search']) ? trim($_GET['search']) : '';

        $returnedItems = $this->model->getReturnedItemsByHierarchy($loggedInEmail, $search);

        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventoryreturns/returned_items_hierarchy.php';
    }

    public function downloadReturnedItems()
    {
        session_start();
    
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
    
        if ($this->model === null) {
            $_SESSION['error_message'] = "Model not loaded properly!";
            header("Location: " . URL . "InventoryReturn/staffreturneditems"); 
            exit();
        }
    
        $loggedInEmail = $_SESSION['user_email'];
        $items = $this->model->getReturnedItemsForDownload($loggedInEmail);
    
        if (empty($items)) {
            $_SESSION['error_message'] = "No returned items available for download.";
            header("Location: " . URL . "InventoryReturn/staffreturneditems"); 
            exit();
        }
    
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="returned_items.csv"');
    
        $output = fopen('php://output', 'w');
    
        fputcsv($output, ['Description', 'Serial Number', 'Returned By', 'Return Date', 'Status', 'Receiver']);
    
        foreach ($items as $item) {
            fputcsv($output, [
                $item['description'],
                $item['serial_number'],
                $item['returned_by_name'],
                $item['return_date'],
                $item['status'],
                $item['receiver_name']
            ]);
        }
    
        fclose($output);
        exit();
    }
    


} 





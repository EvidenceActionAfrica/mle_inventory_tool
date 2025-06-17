<?php

class inventoryassignment extends Controller
{
    // Display all assignments
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
        $assignments = $this->model->getAllAssignments();
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory_assignments/index.php';
    }

    // Add new assignment
    public function add()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $user_id = intval($_POST['user_id']);
            $item_ids = $_POST['inventory_id']; 
            $date_assigned = $_POST['date_assigned'];
            $manager_email = $_POST['managed_by'];

            $result = $this->model->addAssignment($user_id, $item_ids, $date_assigned, $manager_email);

            if (strpos($result, 'successfully') !== false) {
                header("Location: " . URL . "inventoryassignment?success=" . urlencode($result));
            } else {
                header("Location: " . URL . "inventoryassignment?error=" . urlencode($result));
            }
            exit();
        } else {
            $unassignedItems = $this->model->getUnassignedItems();
            $users = $this->model->getAllUsers();
            $offices = $this->model->getOffices(); 
            require APP . 'view/_templates/sessions.php';
            require APP . 'view/_templates/header.php';
            require APP . 'view/inventory_assignments/add_assignment.php';
        }
    }
    //edit assignment
    public function edit($id) {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
    
        $assignment = $this->model->getAssignmentById($id);
        
        if (!$assignment) {
            echo "Assignment not found.";
            return;
        }
    
        // Prevent editing if already acknowledged
        if ($assignment['acknowledgment_status'] !== 'pending') {
            echo "Editing not allowed. The assignment has been acknowledged.";
            return;
        }
    
        // Fetch necessary data
        $unassignedItems = $this->model->getUnassignedItems();
        $users = $this->model->getAllUsers();
        $offices = $this->model->getOffices(); 
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Validate input data
            $updatedData = [
                'user_id' => $_POST['user_id'], 
                'date_assigned' => $_POST['date_assigned'], 
                'managed_by' => $_POST['managed_by']
            ];
    
            // Ensure inventory_id is an array
            if (!empty($_POST['inventory_id']) && is_array($_POST['inventory_id'])) {
                $inventory_ids = $_POST['inventory_id'];
            } else {
                header("Location: " . URL . "inventoryassignment/edit/$id?error=Invalid+inventory+selection");
                exit();
            }
    
            // Call update method with all required parameters
            $result = $this->model->updateAssignment($id, $updatedData, $inventory_ids);
    
            if ($result) {
                header("Location: " . URL . "inventoryassignment?success=" . urlencode("Assignment Updated Successfully"));
                exit();
            } else {
                header("Location: " . URL . "inventoryassignment/edit/$id?error=Update+Failed");
                exit();
            }
        } else {
            // Load edit view with necessary data
            require APP . 'view/_templates/sessions.php';
            require APP . 'view/_templates/header.php';
            require APP . 'view/inventory_assignments/edit_assignment.php';
        }
    }
    
    //delete assignment
    public function delete() {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['assignment_id'])) {
            $id = $_POST['assignment_id'];
            $success = $this->model->deleteAssignment($id);
            if ($success) {
                header("Location: " . URL . "inventoryassignment/index?success=deleted");
                exit();
            } else {
                echo "Deletion failed. The assignment may not be pending.";
            }
        }
    }
    //search button
    public function search() {
        if (!isset($_GET['search']) || empty(trim($_GET['search']))) {
            header("Location: " . URL . "inventoryassignment");
            exit();
        }
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        $search_query = trim($_GET['search']);
        $assignments = $this->model->searchAssignments($search_query);
    
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/inventory_assignments/index.php'; 
    }
    
    // Show pending assignments for the logged-in user
    public function pending()
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

        $user_email = $_SESSION['user_email']; 
        $pendingAssignments = $this->model->getPendingAssignmentsByLoggedInUser($user_email);
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory_assignments/pending_assignments.php';
    }

    // Acknowledge selected assignments
    public function acknowledge()
    {
            if ($this->model === null) {
                echo "Model not loaded properly!";
                exit();
            }
            session_start();

            if (!isset($_SESSION['user_email'])) { // Ensure email exists in session
                header("Location: " . URL . "login");
                exit();
            }
            
            $user_email = $_SESSION['user_email'];
            $assignment_id = $_POST['assignment_id'] ?? null;

            if ($assignment_id) {
                $updated_rows = $this->model->acknowledgeAssignment($assignment_id, $user_email);

                if ($updated_rows > 0) {
                    $_SESSION['success_message'] = "Item acknowledged successfully!";
                } else {
                    $_SESSION['error_message'] = "Failed to acknowledge item. Please try again.";
                }
            }

            header("Location: " . URL . "inventoryassignment/pending");
            exit();
    }

    //report
    //managers reports of assigned items
    public function staffassignments()
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
        $assignments = $this->model->getAssignmentsByHierarchy($loggedInEmail);

        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory_assignments/assignments_hierarchy.php';
    }

    //download reports
    public function downloadAssignments()
    {
        session_start();
    
        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }
        if ($this->model === null) {
            $_SESSION['error_message'] = "Model not loaded properly!";
            header("Location: " . URL . "InventoryAssignment/staffassignments"); // Redirect to staff assignments page
            exit();
        }
    
        $loggedInEmail = $_SESSION['user_email'];
        $assignments = $this->model->getAssignmentsForDownload($loggedInEmail);
    
        if (empty($assignments)) {
            $_SESSION['error_message'] = "No data available for download.";
            header("Location: " . URL . "InventoryAssignment/staffassignments"); // Redirect to staff assignments page
            exit();
        }
    
        // Define the exact column headers you want
        $headers = [
            'user_email', 'department', 'position', 'location',
            'description', 'serial_number', 'tag_number',
            'date_assigned', 'managed_by', 'acknowledgment_status'
        ];
    
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="assignments.csv"');
        header('Pragma: no-cache');
        header('Expires: 0');
    
        $output = fopen('php://output', 'w');
        fputcsv($output, $headers); // Write column headers
    
        foreach ($assignments as $row) {
            $filteredRow = [];
            foreach ($headers as $column) {
                $filteredRow[] = $row[$column] ?? ''; // Ensure columns match headers
            }
            fputcsv($output, $filteredRow);
        }
    
        fclose($output);
        exit();
    }
    
    //button for admis
    // Toggle reconfirm_enabled on all inventory_assignment records
    public function toggleReconfirmation()
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

        $adminEmail = $_SESSION['user_email'];
        $enabled = isset($_POST['enable_reconfirm']) && $_POST['enable_reconfirm'] == '1';

        // Check for existing active session
        $activeSession = $this->model->getActiveReconfirmationSession();

        if ($enabled) {
            if ($activeSession) {
                $_SESSION['error'] = "Reconfirmation is already active. Only {$activeSession['initiated_by']} can deactivate it.";
            } else {
                // Start a new session and get the inserted session ID
                $sessionId = $this->model->startNewReconfirmationSession($adminEmail);

                // Ensure session ID is valid before assigning
                if ($sessionId && is_numeric($sessionId)) {
                    $this->model->assignSessionToUnconfirmed((int)$sessionId);
                    $_SESSION['success'] = "Reconfirmation session started successfully.";
                } else {
                    $_SESSION['error'] = "Failed to start reconfirmation session. Please try again.";
                }
            }
        } else {
            if (!$activeSession) {
                $_SESSION['error'] = "No active reconfirmation session found.";
            } elseif ($activeSession['initiated_by'] !== $adminEmail) {
                $_SESSION['error'] = "Only {$activeSession['initiated_by']} can end this session.";
            } else {
                $this->model->deactivateReconfirmationSession($activeSession['id']);
                $this->model->resetReconfirmToggle();
                $_SESSION['success'] = "Reconfirmation session ended.";
            }
        }

        header("Location: " . URL . "users/getUsers?");
        exit;
    }
    
    //btns for users to recinfirm
    public function confirm() 
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
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $assignmentId = $_POST['assignment_id'];
        
            $activeSession = $this->model->getActiveReconfirmationSession();
        
            if (!$activeSession) {
                $_SESSION['error'] = "No active reconfirmation session.";
                header("Location: " . URL . "inventoryreturn");
                exit();
            }
        
            if ($this->model->confirmAssignment($assignmentId, $activeSession['id'])) {

                $status = 'confirmed';
                $confirmedBy = $_SESSION['user_email']; 
                $this->model->recordConfirmation($assignmentId, $status, $confirmedBy);
        
                // Check if all items have been confirmed
                if ($this->model->allAssignmentsConfirmed()) {
                    $this->model->resetReconfirmToggle();
                }
        
                $_SESSION['success'] = "Item confirmed successfully.";
            } else {
                $_SESSION['error'] = "Failed to confirm item.";
            }
        
            header("Location: " . URL . "inventoryreturn");
            exit();
        }
    }
    
      
    //geetting annual reports
    public function reconfirmationReport()
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
    
        $year = isset($_GET['year']) ? (int)$_GET['year'] : null;
        $month = isset($_GET['month']) ? (int)$_GET['month'] : null;
    
        $reportData = $this->model->getReconfirmationReport($year, $month);
    
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory_assignments/reconfirmation_report.php';
    }
    

}    

?>

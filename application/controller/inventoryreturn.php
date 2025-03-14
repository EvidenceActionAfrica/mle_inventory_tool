<?php

class inventoryreturn extends Controller
{

    public function index()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        
        session_start();
        if (!isset($_SESSION['user'])) {
            header("Location: " . URL . "login");
            exit();
        }
    
        $user_name = $_SESSION['user']; 
        $returned_by = $_SESSION['user'];
        $approvedAssignments = $this->model->getApprovedAssignmentsByLoggedInUser($user_name);
        $returnedItems = $this->model->getReturnedItemsByUser($returned_by);
        
        // Load the view and pass both data sets
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventoryreturns/index.php';
    }
    

// Add a new returned item
public function add()
{
    session_start(); 

    // Check if user is logged in
    if (!isset($_SESSION['user'])) {
        header("Location: " . URL . "login");
        exit();
    }

    if ($this->model === null) {
        echo "Model not loaded properly!";
        exit();
    }

    $assignment_id = $_POST['assignment_id'] ?? ($_GET['assignment_id'] ?? null);

    if (empty($assignment_id)) {
        die('Assignment ID not provided.');
    }

    echo "Assignment ID: " . htmlspecialchars($assignment_id);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $assignment_id = intval($_POST['assignment_id']);
        $return_date = trim($_POST['return_date']);
        $receiver_id = intval($_POST['receiver_id']);
        $status = 'pending';
        $returned_by = $_SESSION['user'];

        if (empty($returned_by)) {
            die('Logged-in user not found.');
        }

        if (!empty($_POST['inventory_ids'])) {
            foreach ($_POST['inventory_ids'] as $item_id) {
                $item_id = intval($item_id);

                $existingReturn = $this->model->getItemReturnStatus($assignment_id, $item_id);
                
                if ($existingReturn) {
                    if ($existingReturn['status'] === 'approved') {
                        echo "Item ID {$item_id} has already been approved and cannot be returned again.";
                        continue; 
                    } else {
                        echo "Item ID {$item_id} is already pending for return.";
                        continue; 
                    }
                }

                $this->model->addItemReturn($assignment_id, $item_id, $return_date, $receiver_id, $status, $returned_by);
            }
        }     
        header("Location: " . URL . "inventoryreturn?success=Items returned successfully!");
        exit();

    } else { // GET: Show form
        $user_name = $_SESSION['user']; 
        $items = $this->model->getApprovedAssignmentsByLoggedInUser($user_name);
        $receivers = $this->model->getReceivers();
        $assignment_id = $_GET['assignment_id'] ?? 0;
        
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventoryreturns/return_item_form.php';
    }  
}


// getting pending approvals for returned item
public function pendingApprovals()
{
    session_start();
    if (!isset($_SESSION['user'])) {
        header("Location: " . URL . "login");
        exit();
    }
    if ($this->model === null) {
        echo "Model not loaded properly!";
        exit();
    }

    $user_email = $_SESSION['user'];
    $pendingApprovals = $this->model->getPendingApprovalsByUser($user_email);

    // Debugging
    echo '<pre>';
    print_r($pendingApprovals);
    echo '</pre>';

    require APP . 'view/_templates/header.php';
    require APP . 'view/inventoryreturns/pendingapprovals.php';
}
} 


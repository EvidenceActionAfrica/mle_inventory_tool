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
    
        $approvedAssignments = $this->model->getApprovedAssignmentsByLoggedInUser($user_name);
        $returnedItems = $this->model->getReturnedItems(); 
        
        // Load the view and pass both data sets
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventoryreturns/index.php';
    }
    

// Add a new returned item
public function add()
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

        if (!empty($_POST['inventory_ids'])) {
            foreach ($_POST['inventory_ids'] as $item_id) {
                $item_id = intval($item_id);
                $this->model->addItemReturn($assignment_id, $item_id, $return_date, $receiver_id, $status);
            }
        }     
        header("Location: " . URL . "inventoryreturn/getReturnedItems?success=Items returned successfully!");
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

} 


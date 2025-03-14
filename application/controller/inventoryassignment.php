<?php

class InventoryAssignment extends Controller
{
    // Display all assignments
    public function index()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        $assignments = $this->model->getAllAssignments();

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
            $location = $_POST['location'];

            $result = $this->model->addAssignment($user_id, $item_ids, $date_assigned, $manager_email, $location);

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

            require APP . 'view/_templates/header.php';
            require APP . 'view/inventory_assignments/add_assignment.php';
        }
    }

    // Edit assignment 
    public function edit()
{
    if ($this->model === null) {
        echo "Model not loaded properly!";
        exit();
    }
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $assignment_id = intval($_POST['assignment_id']);
        $item_ids = $_POST['item_ids'];
        $date_assigned = $_POST['date_assigned'];
        $manager_email = $_POST['managed_by'];
        $location = $_POST['location'];

        $assignment = $this->model->getAssignmentById($assignment_id);

        if (!$assignment) {
            header("Location: " . URL . "inventoryassignment?error=Assignment not found.");
            exit();
        }

        if ($assignment['acknowledgment_status'] !== 'pending') {
            header("Location: " . URL . "inventoryassignment?error=Cannot edit acknowledged items.");
            exit();
        }

        $result = $this->model->updateAssignment($assignment_id, $item_ids, $date_assigned, $manager_email, $location);

        if (strpos($result, 'successfully') !== false) {
            header("Location: " . URL . "inventoryassignment?success=" . urlencode($result));
        } else {
            header("Location: " . URL . "inventoryassignment?error=" . urlencode($result));
        }
        exit();
    } else {
        $assignment_id = $_GET['assignment_id'] ?? null;

        if (!$assignment_id) {
            header("Location: " . URL . "inventoryassignment?error=No assignment selected.");
            exit();
        }

        $assignment = $this->model->getAssignmentById($assignment_id);
        $unassignedItems = $this->model->getUnassignedItems();
        $users = $this->model->getAllUsers();
        $offices = $this->model->getOffices();
        
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory_assignments/edit_assignment.php';
    }
}



    // Delete assignment
    public function delete()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if (isset($_GET['delete'])) {
            $assignment_id = intval($_GET['delete']);
            $result = $this->model->deleteAssignment($assignment_id);

            if (strpos($result, 'successfully') !== false) {
                header("Location: " . URL . "InventoryAssignment?success=" . urlencode($result));
            } else {
                header("Location: " . URL . "InventoryAssignment?error=" . urlencode($result));
            }
            exit();
        }
    }

    // Show pending assignments for the logged-in user
    public function pending()
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

        $pendingAssignments = $this->model->getPendingAssignmentsByLoggedInUser($user_name);

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

            if (!isset($_SESSION['user'])) {
                header("Location: " . URL . "login");
                exit();
            }

            $user_name = $_SESSION['user'];
            $assignment_id = $_POST['assignment_id'] ?? null;

            if ($assignment_id) {
                $updated_rows = $this->model->acknowledgeAssignment($assignment_id, $user_name);

                if ($updated_rows > 0) {
                    $_SESSION['success_message'] = "Item acknowledged successfully!";
                } else {
                    $_SESSION['error_message'] = "Failed to acknowledge item. Please try again.";
                }
            }

            header("Location: " . URL . "inventoryassignment/pending");
            exit();
        }


}

?>

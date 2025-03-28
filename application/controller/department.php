<?php

class Department extends Controller {
    
    // Fetch and display all departments
    public function getDepartments() {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        session_start();

        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }

        // Retrieve departments with hierarchy
        $departments = $this->model->getDepartmentsHierarchy();

        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/configurations/department.php';
    }

    // Add a new department
    public function add() {
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
            $department_name = trim($_POST['department_name']);
            $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : NULL;

            $this->model->addDepartment($department_name, $parent_id);
            header("Location: " . URL . "department/getDepartments?success=Department Added Successfully!");
            exit();
        }
    }

    // Edit department
    public function edit() {
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
            if (!isset($_POST['id']) || !isset($_POST['department_name'])) {
                die("Error: Missing form data!");
            }
    
            $id = intval($_POST['id']);
            $department_name = trim($_POST['department_name']);
            $parent_id = !empty($_POST['parent_id']) ? intval($_POST['parent_id']) : NULL;
    
            $result = $this->model->updateDepartment($id, $department_name, $parent_id);
    
            if ($result) {
                header("Location: " . URL . "department/getDepartments?success=Department Updated Successfully!");
                exit();
            } else {
                die("Error: Failed to update department.");
            }
        }
    }

    // Delete a department
    public function delete() {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        session_start();

        if (!isset($_SESSION['user_email'])) {
            header("Location: " . URL . "login");
            exit();
        }

        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $this->model->deleteDepartment($id);
            header("Location: " . URL . "department/getDepartments?success=Department Deleted Successfully!");
            exit();
        }
    }
}

?>

<?php

class Users extends Controller
{
    // Get all users
    public function getUsers()
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
            $users = $this->model->get_users();
            $departments = $this->model->get_departments();
            $positions = $this->model->get_positions();
            $roles = $this->model->get_roles();
        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/configurations/staff_view.php';
    }

    // Add new user
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
            $email = trim($_POST['email']);
            $department = !empty($_POST['department']) ? intval($_POST['department']) : null;
            $position = !empty($_POST['position']) ? intval($_POST['position']) : null;
            $role = trim($_POST['role']);

            $this->model->insert_user($email, $department, $position, $role);

            header("Location: " . URL . "users/getUsers?success=User Added Successfully!");
            exit();
        }
    }

    // Edit user
    public function edit()
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
            $email = trim($_POST['email']);
            $department = !empty($_POST['department']) ? intval($_POST['department']) : null;
            $position = !empty($_POST['position']) ? intval($_POST['position']) : null;
            $role = trim($_POST['role']);

            $this->model->edit_user($id, $email, $department, $position, $role);

            header("Location: " . URL . "users/getUsers?success=User Updated Successfully!");
            exit();
        }
    }

    // Delete user
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
        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $this->model->delete_user($id);
            
            header("Location: " . URL . "users/getUsers?success=User Deleted Successfully!");
            exit();
        }
    }
}

?>

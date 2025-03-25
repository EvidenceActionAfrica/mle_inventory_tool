<?php

class positions extends Controller
{
    // Fetch and display all positions
    public function getPositions()
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

        // Retrieve all positions
        $positions = $this->model->getPositions();

        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/configurations/positions.php';
    }

    // Add a new position
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
            $position_name = trim($_POST['position_name']);
            $hierarchy_level = intval($_POST['hierarchy_level']);
            $this->model->addPosition($position_name, $hierarchy_level);
            header("Location: " . URL . "positions/getPositions?success=Position Added Successfully!");
            exit();
        }
    }

    // Edit a position
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
            $position_name = trim($_POST['position_name']);
            $hierarchy_level = intval($_POST['hierarchy_level']);
            $this->model->updatePosition($id, $position_name, $hierarchy_level);
            header("Location: " . URL . "positions/getPositions?success=Position Updated Successfully!");
            exit();
        }
    }

    // Delete a position
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
            $this->model->deletePosition($id);
            header("Location: " . URL . "positions/getPositions?success=Position Deleted Successfully!");
            exit();
        }
    }
}

?>

<?php


class categories extends Controller
{
    
    public function getCategory()
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
        // getting all categories
        $categories = $this->model->getCategories();

        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/categories.php';
    }

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
            $category_name = trim($_POST['category_name']);
            $description = trim($_POST['description']);
            $this->model->addCategory($category_name, $description);
            header("Location: " . URL . "categories/getCategory?success=Category Added Successfully!");
            exit();
        }
    }
    // Edit category
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
            $id = intval($_POST['id']);
            $category_name = trim($_POST['category_name']);
            $description = trim($_POST['description']);
            $this->model->updateCategory($id, $category_name, $description);
            header("Location: " . URL . "categories/getCategory?success=Category updated Successfully!");
            exit();
        }
    }

    // Delete category
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
            $this->model->deleteCategory($id);
            header("Location: " . URL . "categories/getCategory?success=Category deleted Successfully!");
            exit();
        }
    }
}

?>

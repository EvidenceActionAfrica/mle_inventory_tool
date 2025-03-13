<?php


class categories extends Controller
{
    
    public function getCategory()
    {
        // getting all categories
        $categories = $this->model->getCategories();

        require APP . 'view/_templates/header.php';
        require APP . 'view/inventory/categories.php';
    }

    public function add()
    {
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
        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $this->model->deleteCategory($id);
            header("Location: " . URL . "categories/getCategory?success=Category deleted Successfully!");
            exit();
        }
    }
}

?>

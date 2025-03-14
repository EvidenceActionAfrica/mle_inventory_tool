<?php

class Office extends Controller
{
    // Fetch all offices
    public function getOffices()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        $offices = $this->model->getOffices();
        $locations = $this->model->getLocations(); // For dropdowns in forms

        require APP . 'view/_templates/header.php';
        require APP . 'view/configurations/office.php';
    }

    // Add new office
    public function add()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $office_name = trim($_POST['office_name']);
            $location_id = intval($_POST['location_id']);
            $this->model->addOffice($office_name,  $location_id);
            header("Location: " . URL . "office/getOffices?success=Office Added Successfully!");
            exit();
        }
    }

    // Edit office
    public function edit()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = intval($_POST['id']);
            $office_name = trim($_POST['office_name']);
            $location_id = intval($_POST['location_id']);
            $this->model->updateOffice($id, $office_name, $location_id);
            header("Location: " . URL . "office/getOffices?success=Office Updated Successfully!");
            exit();
        }
    }

    // Delete office
    public function delete()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $this->model->deleteOffice($id);
            header("Location: " . URL . "office/getOffices?success=Office Deleted Successfully!");
            exit();
        }
    }
}

?>

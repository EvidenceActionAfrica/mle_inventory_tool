<?php

class location extends Controller
{
    // Fetch all locations
    public function getLocations()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        $locations = $this->model->getLocations();

        require APP . 'view/_templates/header.php';
        require APP . 'view/configurations/location.php';
    }

    // Add new location
    public function add()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $location_name = trim($_POST['location_name']);
            $this->model->addLocation($location_name);
            header("Location: " . URL . "location/getLocations?success=Location Added Successfully!");
            exit();
        }
    }

    // Edit location
    public function edit()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = intval($_POST['id']);
            $location_name = trim($_POST['location_name']);
            $this->model->updateLocation($id, $location_name);
            header("Location: " . URL . "location/getLocations?success=Location Updated Successfully!");
            exit();
        }
    }

    // Delete location
    public function delete()
    {
        if ($this->model === null) {
            echo "Model not loaded properly!";
            exit();
        }
        if (isset($_GET['delete'])) {
            $id = intval($_GET['delete']);
            $this->model->deleteLocation($id);
            header("Location: " . URL . "location/getLocations?success=Location Deleted Successfully!");
            exit();
        }
    }
}

?>

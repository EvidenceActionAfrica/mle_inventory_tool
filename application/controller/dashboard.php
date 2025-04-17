<?php

class dashboard extends Controller
{
    
    public function index()
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
        // Fetch item states data ie functional, lost or damaged(donut chart)
        $itemStates = $this->model->getItemStates();
        // Fetch counts for inuse and in stock from the database(pie chart)
        $inUseCount = $this->model->getInUseCount(); 
        $inStockCount =$this->model->getInStockCount();
        //fetch for categories(barchart)
        $itemCounts = $this->model->getItemCountsByCategory();

        require APP . 'view/_templates/sessions.php';
        require APP . 'view/_templates/header.php';
        require APP . 'view/_templates/dashboard.php';
    }

}

?>
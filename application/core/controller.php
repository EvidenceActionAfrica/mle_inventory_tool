<?php

class Controller
{
    public $db = null;
    public $model = null;

    public function __construct()
    {
        $this->openDatabaseConnection();
        $this->loadModel();
    }

    private function openDatabaseConnection()
    {
        $dsn = 'mysql:host=localhost;dbname=mle_inventory;charset=utf8';
        $username = 'root';
        $password = '';

        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Use EXCEPTION for better debugging
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->db = new PDO($dsn, $username, $password, $options);
            //echo "Database connected successfully!";
        } catch (PDOException $e) {
            die('Connection failed: ' . $e->getMessage());
        }
    }

    public function loadModel()
    {
        $modelPath = APP . 'model/model.php';
        if (file_exists($modelPath)) {
            require $modelPath;
            $this->model = new Model($this->db);
        } else {
            die('Model file not found: ' . $modelPath);
        }
    }
}

<?php
  if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

//using role because it is set on login
if (empty($_SESSION["role"])){
                    
    header('location: ' . URL . 'login/index'  );
    exit;

}

?>

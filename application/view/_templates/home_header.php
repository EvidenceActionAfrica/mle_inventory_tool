<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$role = $_SESSION['role'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="MLE Inventory Tool">
    <meta name="author" content="Evidence Action">
    <title>Evidence Action</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <!-- CSS -->
    <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">

    <style>
    @font-face {
        font-family: ArchivoBlack;
        src: url("<?php echo URL;?>/fonts/ArchivoBlack-Regular.ttf");
    }

    .bt-logout {
        background-color: #20253a;
        color: #fff;
        border-style: none;
        padding: .5rem 1rem;
        font-size: 16px;
        border-radius: 5px;
        margin-right: 2rem;
        text-decoration: none;
    }

    .dfaicjcsbg2 {
        display: flex; 
        align-items: center; 
        justify-content: space-between; 
        gap: 2rem;
    }

    .nav-option {
        text-align: center;
        text-decoration: none;
        font-size: 15px;
        padding: .8rem .6rem;
        color: #20253a;
        margin-left: 1rem;
        font-family: ArchivoBlack;
    }

    .nav-option:hover, .dropdown-item:hover {
        background-color: #ecfafb;
    }

    .active, .nav-item.active, .nav-item.active .nav-link, .dropdown-item.active {
        background-color: #d5f4f7 !important;
        border-bottom: 3px solid #05545a;
        font-weight: 600;
        text-decoration: underline;
        color: #05545a;
    }

    .nav-item.active .nav-link {
        font-weight: bold;
    }

    .dropdown {
        position: relative;
        display: inline-block;
    }

    .dropdown-toggle {
        cursor: pointer;
    }

    .dropdown-menu {
        display: none;
        position: absolute;
        background-color: #fff;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        min-width: 200px;
        z-index: 1000;
    }

    .dropdown-item {
        padding: 10px;
        font-size: 14px;
        color: #20253a;
        text-decoration: none;
        display: block;
    }

    .dropdown:hover .dropdown-menu {
        display: block;
    }

    .dropdown .active {
        font-weight: bold;
    }
    </style>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
</head>

<div class="top-nav navbar navbar-expand-lg navbar-light bg-white px-3">
    <a href="<?php echo URL; ?>home" class="navbar-brand">
        <img src="<?php echo URL; ?>img/ea_logo.png" alt="logo" style="padding: 10px; width: 150px; height: auto;">
</a>
    <div class="d-flex align-items-center justify-content-end w-100">
        <!-- Display user name if logged in -->
        <?php 
        if (isset($_SESSION['user_email'])) {
            $user_email = $_SESSION['user_email'];
            $user_name = ucwords(explode('@', $user_email)[0]);
            echo "<p class='mb-0 me-3'><b>" . htmlspecialchars($user_name) . "!</b></p>";
        }
        ?>
        <a href="<?php echo URL; ?>login/logout" class="bt-logout">LOGOUT</a>
    </div>
</div>


<body>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>      
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</body>
</html>

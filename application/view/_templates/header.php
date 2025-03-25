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
        <title>Evidence Action</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <!-- CSS -->
        <link href="<?php echo URL; ?>css/style.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous" />
        
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js" crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        
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

        .active {

            border-bottom: 3px solid #05545a;
            background-color: #d5f4f7 !important;
            font-weight: 600;
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
    <body>

    <?php
$current_page = basename($_SERVER['REQUEST_URI']);

// Define sections with corresponding URLs
$assets_pages = ['unassignedItems', 'assignedItems'];
$reports_pages = ['staffassignments', 'staffreturneditems'];
$collections_pages = ['approve', 'lostItems', 'damagedItems', 'disposedItems'];
$config_pages = ['inventory', 'users/getUsers','categories/getCategory'];
$admin_pages = [ 'office/getOffices', 'location/getLocations','positions/getPositions','department/getDepartments'];

function isActive($page, $current_page)
{
    return strpos($current_page, $page) !== false ? 'active' : '';
}
?>

<div class="top-nav dfaicjcsbg2">

    <a href="<?php echo URL; ?>home">
        <img src="<?php echo URL; ?>img/ea_logo.png" alt="logo" style="padding: 10px; width: 150px; height: auto;">
    </a>

    <div>
        <!-- Main links -->
        <?php if($role === 'admin'|| $role === 'staff' || $role === 'super_admin'): ?>
        <a href="<?php echo URL; ?>InventoryAssignment/pending" class="nav-option <?php echo isActive('InventoryAssignment/pending', $current_page); ?>">PENDING ASSIGNMENTS</a>
        <?php endif; ?>
        <?php if($role === 'admin'||  $role === 'super_admin'): ?>
        <a href="<?php echo URL; ?>InventoryAssignment" class="nav-option <?php echo isActive('InventoryAssignment', $current_page); ?>">ASSIGNMENTS</a>
        <?php endif; ?>
        <?php if($role === 'admin'|| $role === 'staff' || $role === 'super_admin'): ?>
        <a href="<?php echo URL; ?>inventoryreturn" class="nav-option <?php echo isActive('inventoryreturn', $current_page); ?>">RETURN ITEM</a>
        <?php endif; ?>
        <!-- Dropdown menus -->
        <?php if($role === 'admin'||  $role === 'super_admin'): ?>
        <div class="dropdown">
            <a href="#" class="nav-option dropdown-toggle <?php echo in_array($current_page, $assets_pages) ? 'active' : ''; ?>">ASSETS</a>
            <div class="dropdown-menu">
                <a href="<?php echo URL; ?>inventoryreturn/unassignedItems" class="dropdown-item <?php echo isActive('unassignedItems', $current_page); ?>">In-Stock</a>
                <a href="<?php echo URL; ?>inventoryreturn/assignedItems" class="dropdown-item <?php echo isActive('assignedItems', $current_page); ?>">In-Use</a>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role === 'admin'|| $role === 'super_admin'): ?>
        <div class="dropdown">
            <a href="#" class="nav-option dropdown-toggle <?php echo in_array($current_page, $collections_pages) ? 'active' : ''; ?>">COLLECTIONS</a>
            <div class="dropdown-menu">
                <a href="<?php echo URL; ?>inventoryreturn/approve" class="dropdown-item <?php echo isActive('approve', $current_page); ?>">Pending Approvals</a>
                <a href="<?php echo URL; ?>inventoryreturn/lostItems" class="dropdown-item <?php echo isActive('lostItems', $current_page); ?>">Lost Inventory</a>
                <a href="<?php echo URL; ?>inventoryreturn/damagedItems" class="dropdown-item <?php echo isActive('damagedItems', $current_page); ?>">Repairs</a>
                <a href="<?php echo URL; ?>inventoryreturn/disposedItems" class="dropdown-item <?php echo isActive('disposedItems', $current_page); ?>">Disposed</a>
            </div>
        </div>
        <?php endif; ?>

        <?php if($role === 'admin'|| $role === 'staff' || $role === 'super_admin'): ?>
        <div class="dropdown">
            <a href="#" class="nav-option dropdown-toggle <?php echo in_array($current_page, $reports_pages) ? 'active' : ''; ?>">REPORTS</a>
            <div class="dropdown-menu">
                <a href="<?php echo URL; ?>InventoryAssignment/staffassignments" class="dropdown-item <?php echo isActive('managerAssignments', $current_page); ?>">Staff Assignments</a>
                <a href="<?php echo URL; ?>inventoryreturn/staffreturneditems" class="dropdown-item <?php echo isActive('returnedItems', $current_page); ?>">Staff Returned Items</a>
            </div>
        </div>
        <?php endif; ?>
        <?php if($role === 'admin'|| $role === 'super_admin'): ?>
        <div class="dropdown">
            <a href="#" class="nav-option dropdown-toggle <?php echo in_array($current_page, $config_pages) ? 'active' : ''; ?>">CONFIGURATIONS</a>
            <div class="dropdown-menu">
                <a href="<?php echo URL; ?>inventory" class="dropdown-item <?php echo isActive('inventory', $current_page); ?>">Inventory</a>
                <a href="<?php echo URL; ?>categories/getCategory" class="dropdown-item <?php echo isActive('categories/getCategory', $current_page); ?>">Categories</a>
                <a href="<?php echo URL; ?>users/getUsers" class="dropdown-item <?php echo isActive('users/getUsers', $current_page); ?>">Users</a>
            </div>
        </div>
        <?php endif; ?>
        <?php if($role === 'super_admin'): ?>
        <div class="dropdown">
            <a href="#" class="nav-option dropdown-toggle <?php echo in_array($current_page, $admin_pages) ? 'active' : ''; ?>">ADMIN</a>
            <div class="dropdown-menu">
                <a href="<?php echo URL; ?>positions/getPositions" class="dropdown-item <?php echo isActive('positions/getPositions', $current_page); ?>">Positons</a>
                <a href="<?php echo URL; ?>department/getDepartments" class="dropdown-item <?php echo isActive('department/getDepartments', $current_page); ?>">Departments</a>
                <a href="<?php echo URL; ?>office/getOffices" class="dropdown-item <?php echo isActive('office/getOffices', $current_page); ?>">Office</a>
                <a href="<?php echo URL; ?>location/getLocations" class="dropdown-item <?php echo isActive('location/getLocations', $current_page); ?>">Location</a>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <div class="dfaicjcsbg2">
        <?php 
        if (isset($_SESSION['user_email'])) {
            $user_email = $_SESSION['user_email'];
            $user_name = ucwords(explode('@', $user_email)[0]);
            echo "<p><b> " . htmlspecialchars($user_name) . "!</b></p>";
        }
        ?>
        <a href="<?php echo URL; ?>login/logout" class="bt-logout">LOGOUT</a>
    </div>
</div>

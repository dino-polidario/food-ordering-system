<?php
$rootPath = (basename(dirname($_SERVER['PHP_SELF'])) == 'pages') ? '../' : './';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RR Musubi</title>
    <link rel="stylesheet" href="<?php echo $rootPath; ?>assets/css/global.css">
    <link rel="stylesheet" href="<?php echo $rootPath; ?>assets/css/menu.css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Feeling+Passionate&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <a class="logo" href="<?php echo $rootPath; ?>index.php">
        <img src="<?php echo $rootPath; ?>assets/img/store-logo.png" alt="logo" class="logo-img">
        <span>RR Musubi</span>
    </a>
    
    <ul class="nav-links">
        <li><a href="<?php echo $rootPath; ?>index.php"
            class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Home</a></li>
        <li><a href="<?php echo $rootPath; ?>pages/menu.php"
            class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Menu</a></li>
        <li><a href="<?php echo $rootPath; ?>pages/about.php"
            class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">About</a></li> <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li><a href="<?php echo $rootPath; ?>pages/admin_dashboard.php"
                class="<?= $currentPage === 'index.php' ? 'active' : '' ?>">Admin Panel</a></li>
        <?php endif; ?>
    </ul>

    <ul class="nav-user">
        <?php if(isset($_SESSION['user_id'])): ?>
            <li><a href="<?php echo $rootPath; ?>pages/customer_dashboard.php"><i class="material-icons">person</i></a></li>
            <li><a href="<?php echo $rootPath; ?>pages/cart.php" class="cart-link">
                <i class="material-icons">shopping_cart</i>
                <span class="cart-badge">0</span></a></li>
            <li><a href="<?php echo $rootPath; ?>pages/reviews_ratings.php"><i class="material-icons rating-icon">star</i></a></li> <?php if(isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
            <li><button class="order-btn" onclick="showPage('menu')">ORDER NOW</button></li>    
            <li><a href="<?php echo $rootPath; ?>includes/logout.php" class="order-btn" style="padding: 0.5rem 1rem; font-size: 0.8rem;">LOGOUT</a></li><?php else: ?>
            <li><a href="<?php echo $rootPath; ?>pages/login.php" class="order-btn">LOGIN</a></li>
        <?php endif; ?>
        <?php endif; ?>
    </ul>
</nav>
<?php
require_once 'db/db.php';
require_once 'classes/product.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
error_reporting(0);

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$data = new db();
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
} else {
    $email = "None";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>E & A</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins&family=Roboto:wght@700&display=swap" rel="stylesheet">  

    <!-- Icon Font Stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="lib/flaticon/font/flaticon.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">

    <style>
        /* Hide buttons with the admin-btn class */
        .admin-btn {
            display: none;
        }
    </style>
</head>   
<body>
    <!-- Topbar Start -->
    <div class="container-fluid border-bottom d-none d-lg-block">
        <div class="row gx-0">
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-geo-alt fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Our Office</h6>
                        <span>123 Street, New York, USA</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center border-start border-end py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-envelope-open fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Email Us</h6>
                        <span>asilshami53@gmail.com</span><br>
                        <span>emankrem0612@gmail.com</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center py-2">
                <div class="d-inline-flex align-items-center">
                    <i class="bi bi-phone-vibrate fs-1 text-primary me-3"></i>
                    <div class="text-start">
                        <h6 class="text-uppercase mb-1">Call Us</h6>
                        <span>+972 52-834-6031</span><br>
                        <span>+972 54-904-2165</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Topbar End -->

    <!-- Navbar Start -->
    <nav class="navbar navbar-expand-lg bg-white navbar-light shadow-sm py-3 py-lg-0 px-3 px-lg-0">
        <a href="index.php" class="navbar-brand ms-lg-5">
            <h1 class="m-0 text-uppercase text-dark"><i class="bi bi-shop fs-1 text-primary me-3"></i>E & A</h1>
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="navbar-nav ms-auto py-0">
                <!-- ... (Other buttons in the navbar) ... -->
                <?php
                if ($email === "None") {
                    // User is not logged in, show only login button
                    echo '<a href="login.php" class="nav-item nav-link">Login</a>';
                } else if ($data->check_if_exist('admin', 'email', $email) || $data->check_if_exist('worker', 'email', $email)){
                    // User is logged in, show logout button
                    echo '<form class="nav-item" action="login.php" method="post">';
                    echo '<input type="hidden" class="nav-item nav-link" name="logout" value="true">';
                    echo '<button type="submit" class="nav-link btn btn-link">Logout</button>';
                    echo '</form>';
                } else {
                    // User is logged in and not admin or worker, show all other buttons
                    echo '<a href="index.php" class="nav-item nav-link">Home</a>';
                    echo '<a href="cart.php" class="nav-item nav-link">Cart</a>';
                    echo '<a href="about.php" class="nav-item nav-link">About</a>';
                    echo '<a href="wishlist.php" class="nav-item nav-link">Wishlist</a>';
                    echo '<a href="order.php" class="nav-item nav-link">Orders</a>';
                    echo '<a href="contact.php" class="nav-item nav-link">Contact</a>';
                    echo '<form class="nav-item" action="login.php" method="post">';
                    echo '<input type="hidden" class="nav-item nav-link" name="logout" value="true">';
                    echo '<button type="submit" class="nav-link btn btn-link">Logout</button>';
                    echo '</form>';
                }
                ?>
                <div class="nav-item nav-link" style="display: flex; justify-content: center;">
                    <form action="search.php" method="GET">
                        <input type="text" placeholder="Search.." name="search">
                        <button class="btn btn-primary py-2 px-3" type="submit"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <!-- Navbar End -->
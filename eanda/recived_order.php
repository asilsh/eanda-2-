<?php
include 'inc/header.php';
require_once 'db/reviews_orders.php';
require_once 'db/db.php';
require_once 'classes/customer.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}

// Retrieve user information from the session
$email = $_SESSION['email'];
$name = $_SESSION['email'];

// Create a new instance of the db class
$data = new db();

$column = "email"; // Replace with the actual column name for email

$id_o = $_GET['id_o']; // Retrieve the id_o from the session
if(!$data->complete('order', $id_o, 'complete')){
    echo "Something went wrong.";
}

$table = 'customer';
$column = 'email';
?>
    <!-- Thanks msg Start -->
<br><br>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.3/css/bootstrap.min.css">

<div class="container" style="margin-top: 5%;">
    <div class="row">
        <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
            <h2 class="text-center">YOUR ORDER HAS BEEN COMPLETE</h2>
            <h3 class="text-center">Enjoy your order</h3>
          
            <p class="text-center">Your order # is: <?php echo $id_o ?></p>
            <p class="text-center">Thank you for choosing us.</p>
            
            <div class="text-center" style="margin-top: 50px;">
            <a href="review_order.php?id_o=<?php echo $id_o; ?>" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Review</a>
            </div>
        </div>
    </div>
</div>

    <!-- Thanks msg End -->
<?php
include 'inc/footer.php';?>

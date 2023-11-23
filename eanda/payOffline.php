<?php
include 'inc/header.php';
require_once 'db/login_register.php';
require_once 'db/db.php';
require_once 'classes/customer.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

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

if($data->userType("customer", $email)){
    $table = "customer"; // Replace with the actual table name
    echo '<script>alert("Customer!");</script>';
} else if($data->userType("admin", $email)){
    $_SESSION['isAdmin'] = true;
    $table = "admin"; // Replace with the actual table name
    echo '<script>alert("Admin!");</script>';
} else if($data->userType("worker", $email)) {
    $table = "worker"; // Replace with the actual table name
    echo '<script>alert("Worker!");</script>';
} else {
  echo '<script>alert("hi!");</script>';
}

$id_o = $_SESSION['id_o']; // Retrieve the id_o from the session

$table = 'customer';
$column = 'email';
?>
    <!-- Thanks msg Start -->
<br><br>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.3/css/bootstrap.min.css">

<div class="container" style="margin-top: 5%;">
    <div class="row">
        <div class="jumbotron" style="box-shadow: 2px 2px 4px #000000;">
            <h2 class="text-center">YOUR ORDER HAS BEEN RECEIVED</h2>
            <h3 class="text-center">Thank you for your payment, it’s processing</h3>
          
            <p class="text-center">Your order # is: <?php echo $id_o ?></p>
            <p class="text-center">Thank you for choosing us.</p>
            
            <div class="text-center" style="margin-top: 50px;">
            <a href="index.php" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Home</a>
            </div>
        </div>
    </div>
</div>

    <!-- Thanks msg End -->
<?php
include 'inc/footer.php';
?>
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

$customerInfo = $data->getCustomerByEmail($table, $column, $email);
if ($customerInfo) {
    $phone = $customerInfo['phone'];
    $city = $customerInfo['city'];
    $password = $customerInfo['password'];
    // Display other customer information as needed
} else {
    echo "Customer information not found.";
}

// Check if customer information is found
if ($customerInfo) {
    // Extract the desired information from the customer array
    $name = isset($customerInfo['name']) ? $customerInfo['name'] : '';
    // Extract other customer information if available
?>
    <!-- Profile Start -->
<br><br>
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method="POST">
          <!-- Name input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Full-Name</label>
            <input type="text" name="name" id="form3Example3" class="form-control form-control-lg"
            value="<?php echo $name; ?>" />
          </div>

          <!-- Phone input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Phone number</label>
            <input type="text" name="phone" id="form3Example3" readonly oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control form-control-lg"
            value="<?php echo $phone; ?>" />
          </div>

          <!-- City input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">City</label>
            <input type="text" name="city" id="form3Example3" class="form-control form-control-lg" 
                value="<?php echo $city; ?>" />
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Email</label>
            <input type="text" name="email" id="form3Example3" class="form-control form-control-lg" 
                value="<?php echo $email; ?>" readonly/>
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
          <label class="form-label" for="form3Example4">Password</label>
            <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
            value="<?php echo $password; ?>" />
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;" name="update">Update</button>
          </div>
          <div class="clear"></div>
        </form>
      </div>
    </div>
  </div>
</section>
    <!-- Profile End -->
    <?php
} else {
    echo 'Customer information not found.';
}

include 'inc/footer.php';
?>

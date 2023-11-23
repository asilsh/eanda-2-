<?php include 'inc/header.php';
include 'db/login_register.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

// Check if the login form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Perform login validation and verification
    // Assuming the login is successful, you can store the user information in the session

    // Assuming $user is an array containing user information retrieved from the database
    $user = [
        'email' => 'user@example.com',
        'name' => 'John Doe',
        'password' => 'hashed_password',
        'city' => 'New York',
        'phone' => '1234567890'
    ];

    // Store user information in the session
    $_SESSION['loggedin'] = true;
    $_SESSION['email'] = $_POST['email'];
    // $_SESSION['name'] = $_POST['name'];
    // You can store other user information in the session as well
    // $_SESSION['cart_user_name'] = $_POST['name'];
    

    // Redirect to the about page
    // header("Location: about.php");
    // exit;
}

?>

<br><br><br>
<!-- Login Start -->
    <section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
      <form method="POST">
          <!-- Email input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Email address</label>
            <input type="email" name="email" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a valid email address" />
          </div>

          <!-- Phone input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Phone number</label>
            <input type="text" name="phone" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a phone number" />
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
          <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;" name="reset">Reset Passowrd</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Do have an account? <a href="register.php"
                class="link-danger">Login</a></p>
          </div>

        </form>
      </div>
    </div>
  </div>
  <div>
    <!-- Right -->
    <div>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-facebook-f"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-twitter"></i>
      </a>
      <a href="#!" class="text-white me-4">
        <i class="fab fa-google"></i>
      </a>
      <a href="#!" class="text-white">
        <i class="fab fa-linkedin-in"></i>
      </a>
    </div>
    <!-- Right -->
  </div>
</section>
<!-- Login Eng -->

    <?php include 'inc/footer.php'; ?>
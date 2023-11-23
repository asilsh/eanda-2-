<?php
include 'inc/header.php';
include 'db/login_register.php';

?>

<br><br><br>
<!-- Register Start -->
<section class="vh-100">
  <div class="container-fluid h-custom">
    <div class="row d-flex justify-content-center align-items-center h-100">
      <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
        <form method="POST">
          <!-- Name input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Full-Name</label>
            <input type="text" name="name" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a full name" />
          </div>

          <!-- Phone input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Phone number</label>
            <input type="text" name="phone" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a phone number" />
          </div>

          <!-- City input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">City</label>
            <input type="text" name="city" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a city" />
          </div>

          <!-- Email input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Email address</label>
            <input type="email" name="email" id="form3Example3" class="form-control form-control-lg"
              placeholder="Enter a valid email address" />
          </div>

          <!-- Password input -->
          <div class="form-outline mb-3">
          <label class="form-label" for="form3Example4">Password</label>
            <input type="password" name="password" id="form3Example4" class="form-control form-control-lg"
              placeholder="Enter password" />
          </div>

          <div class="text-center text-lg-start mt-4 pt-2">
            <button type="submit" class="btn btn-primary btn-lg"
              style="padding-left: 2.5rem; padding-right: 2.5rem;" name="register">Register</button>
            <p class="small fw-bold mt-2 pt-1 mb-0">Have an account? <a href="login.php"
                class="link-danger">Login</a></p>
          </div>
          <div class="clear"></div>
        </form>
      </div>
    </div>
  </div>
</section>
<!-- Login Eng -->

<?php include 'inc/footer.php'; ?>
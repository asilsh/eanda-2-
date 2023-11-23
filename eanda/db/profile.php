<?php
# Page not exist why!

session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // User is not logged in, redirect to the login page
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}

// Retrieve user information from the session
$email = $_SESSION['email'];
$name = $_SESSION['name'];
// Retrieve other user information from the session if available
?>

<!-- Profile Start -->
<div class="container">
    <div class="row">
        <!-- edit form column -->
        <div class="col-md-9 personal-info">
            <br>
            <h3>Personal info</h3>
            <br>
            <form class="form-horizontal" role="form">
                <div class="form-group">
                    <label class="col-lg-3 control-label">Full name</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="<?php echo $name; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <br><label class="col-lg-3 control-label">Email:</label>
                    <div class="col-lg-8">
                        <input class="form-control" type="text" value="<?php echo $email; ?>">
                    </div>
                </div>
                <!-- Add more form fields to display other user information -->
                <div class="form-group">
                    <label class="col-md-3 control-label"></label>
                    <div class="col-md-8">
                        <input type="button" class="btn btn-primary" value="Save Changes">
                        <span></span>
                        <input type="reset" class="btn btn-default" value="Cancel">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- Profile End -->

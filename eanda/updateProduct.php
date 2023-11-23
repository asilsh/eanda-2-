<?php
include 'inc/header.php';
require_once 'db/product_cart.php';
require_once 'db/db.php';
require_once 'classes/product.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Create a new instance of the db class
$data = new db();

// Check if the form is submitted
if (isset($_POST['update'])) {
    $id_p = $_POST['id_p'];
    $name = $_POST['name'];
    $body = $_POST['body'];
    $price = $_POST['price'];
    $inventory = $_POST['inventory'];
}

// Retrieve the product details
$id_p = $_GET['id_p'];
$productDetails = $data->getProductByID('product', 'id_p', $id_p);

?>

<!-- Insert product Start -->
<div class="container">
    <br><br>
    <h2 class="mb-5">Update Product</h2>
<form method="POST">
    <!-- ID input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Product ID</label>
        <input type="text" name="id_p" id="form3Example3" 
        class="form-control form-control-lg" value="<?php echo $productDetails['id_p']; ?>" readonly/>
    </div>
    <!-- Name input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Product Name</label>
        <input type="text" name="name" id="form3Example3" class="form-control form-control-lg" value="<?php echo $productDetails['name']; ?>" />
    </div>
    <!-- Information input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Information</label>
        <input type="text" name="body" id="form3Example3" class="form-control form-control-lg" value="<?php echo $productDetails['body']; ?>" />
    </div>
    <!-- Price input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Price</label>
        <input type="text" name="price" id="form3Example3" pattern="[0-9]+" title="Please enter a valid number" class="form-control form-control-lg" value="<?php echo $productDetails['price']; ?>" />
    </div>
    <!-- Inventory input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Inventory</label>
        <input type="text" name="inventory" id="form3Example3" class="form-control form-control-lg" pattern="[0-9]+" title="Please enter a valid number" value="<?php echo $productDetails['inventory']; ?>"  readonly/>
    </div>
    <!-- S input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Size S</label>
        <input type="text" name="s" id="form3Example3" class="form-control form-control-lg" pattern="[0-9]+" title="Please enter a valid number" value="<?php echo $productDetails['s']; ?>" />
    </div>
    <!-- M input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Size M</label>
        <input type="text" name="m" id="form3Example3" class="form-control form-control-lg" pattern="[0-9]+" title="Please enter a valid number" value="<?php echo $productDetails['m']; ?>" />
    </div>
    <!-- L input -->
    <div class="form-outline mb-4">
        <label class="form-label" for="form3Example3">Size L</label>
        <input type="text" name="l" id="form3Example3" class="form-control form-control-lg" pattern="[0-9]+" title="Please enter a valid number" value="<?php echo $productDetails['l']; ?>" />
    </div>
    <!-- Insert button -->
    <div style="display: inline-block; margin-right: 10px;">
        <button type="submit" class="btn btn-primary btn-lg" style="width: 100px; margin-right: 10px;" name="update">Update</button>
        <button type="submit" class="btn btn-primary btn-lg" style="width: 100px; margin-right: 10px;" name="delete">Delete</button>
        <button type="button" class="btn btn-primary btn-lg" style="width: 100px; margin-right: 10px;" onclick="window.location.href = 'insertProduct.php';">Back</button>
    </div>
</form>
<!-- Insert product End -->

<script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Insert product End -->
    <?php
    include 'inc/footer.php';
    ?>

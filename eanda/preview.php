<?php 
include 'inc/header.php'; 
require_once 'db/product_cart.php';
require_once 'db/db.php';
require_once 'classes/product.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Create a new instance of the db class
$data = new db();

$email = $_SESSION['email'];
$id_p = $_GET['id_p'];

$review_info = $data->review_orders('review', $id_p);


// Retrieve the product details
$productDetails = $data->getProductByID('product', 'id_p', $id_p);

if (!empty($productDetails)) {
        $id_p = $productDetails['id_p'];
        $name = $productDetails['name'];
        $body = $productDetails['body'];
        $price = $productDetails['price'];
        $inventory = $productDetails['inventory'];
        $image = $productDetails['image'];
        $status_s = $productDetails['status_s'];
        $status_m = $productDetails['status_m'];
        $status_l = $productDetails['status_l'];
} else {
    echo '<script>alert("Product not found");</script>';
}

?>

	<html>
	<head>
	    <link rel="stylesheet" type="text/css" href="fonts/icomoon/icomoon.css">
	    <link rel="stylesheet" type="text/css" href="css/slick.css"/>
		<link rel="stylesheet" type="text/css" href="css/slick-theme.css"/>
		<link rel="stylesheet" type="text/css" href="css/magnific-popup.css"/>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>

		<link href="https://fonts.googleapis.com/css2?family=Merriweather:ital,wght@0,400;0,700;1,400;1,700&display=swap" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	    <link rel="stylesheet" type="text/css" href="style.css">

	</head>
	<body>
<section class="bg-sand padding-large">
	<div class="container">
		<div class="row">

			<div class="col-md-6">
                <img class="img-fluid mb-4" src="<?php echo $image; ?>" alt="">
			</div>

            <div class="col-md-6 pl-5">
            <div class="product-detail">
                <h5 class="pt-5" name="name"><a href="#"><?php echo $name; ?></a></h5>
                <span class="price colored" name="price"><?php echo $price; ?>$</span>
                <p>
                    <?php echo $body; ?>
                </p>

                <h6 class="price colored" name="price">Size S: <?php echo $status_s; ?></h6>
                <h6 class="price colored" name="price">Size M: <?php echo $status_m; ?></h6>
                <h6 class="price colored" name="price">Size L: <?php echo $status_l; ?></h6>

                <br>
                <form method="POST">

                <label for="size">Size</label>
                <select id="size" name="size" class="input-select">
                    <option value="s">S</option>
                    <option value="m">M</option>
                    <option value="l">L</option>
                </select>

                    <input type="number" id="qty" class="input-text qty text" step="1" min="1" max="100" name="quantity" value="1" title="Qty" size="4" placeholder="" inputmode="numeric">
                    <br><br>

                    <!-- Cart Button -->
                    <button class="btn btn-primary py-2 px-3" name="cart" type="submit">
                        <i class="bi bi-cart"></i>
                    </button>

                    <!-- Star Button -->
                    <button class="btn btn-primary py-2 px-3" name="star" type="submit">
                        <i class="bi bi-star"></i>
                    </button>

                </form> <!-- Close the form tag here -->
                <br> <br>
                <h2>Reviews</h2>
                <br>
                <form method="POST">
                    <div class="table-responsive custom-table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">ID</th> <!-- Add ID column -->
                                    <th scope="col">Item Name</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Review</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($review_info as $row) {
                                    $id_p = $row['id_p'];
                                    $review = $row['review'];
                                    $product_info = $data->getProductByID('product', 'id_p', $id_p);

                                    if ($product_info) {
                                ?>
                                        <tr scope="row">
                                            <td><a href="#"><?php echo $row['id_r']; ?></td>
                                            <td><?php echo $product_info['name']; ?></a></td>
                                            <td>
                                                <img src="<?php echo $product_info['image']; ?>" 
                                                    style="width: 100px; height: 100px;">
                                            </td>
                                            <td><?php echo $review; ?></td>
                                        </tr>
                                <?php
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </form>

            </div>
        </div>
		</div>
	</div>
</section>

    <script src="js/jquery-1.11.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.bundle.min.js"></script>
	<script type="text/javascript" src="js/slick.min.js"></script>
	<script type="text/javascript" src="js/jquery.magnific-popup.min.js"></script>
	<script type="text/javascript" src="js/script.js"></script>

</body>
<?php include 'inc/footer.php'; ?>
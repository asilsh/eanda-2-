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

$email = $_SESSION['email'];
// echo '<script>alert("Email: ' . $email . '");</script>';

// Retrieve the product details
$gender = $_GET['gender'];
$clothing_jewelry = $_GET['clothing_jewelry'];
$productDetails = $data->getProductByTypeAndName('product', 'gender', $gender, 'clothing_jewelry', $clothing_jewelry);

if (!empty($productDetails)) {
    foreach ($productDetails as $product) {
        $id_p = $product['id_p'];
        $name = $product['name'];
        $body = $product['body'];
        $price = $product['price'];
        $inventory = $product['inventory'];
        $image = $product['image'];
    }
} else {
    echo '<script>alert("Product not found");</script>';
}

?>

    <!-- Products Start -->
    <div class="container-fluid py-5">
        <div class="container">
            <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
                <h6 class="text-primary text-uppercase">Products</h6>
                <h1 class="display-5 text-uppercase mb-0">Products For Your Style</h1>
            </div>
            <div class="owl-carousel product-carousel">
                <?php foreach ($productDetails as $product): ?>
                <div class="pb-5">
                <form method="POST" actin="">
                    <div class="product-item position-relative bg-light d-flex flex-column text-center">
                        <img class="img-fluid mb-4" src="<?php echo $product['image']; ?>" alt="">
                        <h6 class="text-uppercase"><?php echo $product['name']; ?></h6>
                        <h6 class="text-lowercase"><?php echo $product['body']; ?></h6>
                        <!-- <h6 class="text-lowercase"><?php echo $product['status']; ?></h6> -->
                        <h5 class="text-primary mb-0">$<?php echo $product['price']; ?></h5>
                        <div class="btn-action d-flex justify-content-center">
                        <button class="btn btn-primary py-2 px-3" name="fullscreen" type="submit">
                            <i class="bi bi-arrows-fullscreen"></i>
                        </button>
                        </div>
                        <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                        <input type="hidden" name="body" value="<?php echo $product['body']; ?>">
                    </div>
                </form>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <!-- Products End -->


    <!-- Offer Start -->
    <br><br><br><br><br><br>
    <div class="container-fluid bg-offer my-5 py-5">
        <div class="container py-5">
            <div class="row gx-5 justify-content-start">
                <div class="col-lg-7">
                    <div class="border-start border-5 border-dark ps-5 mb-5">
                        <h6 class="text-dark text-uppercase">Special Offer</h6>
                        <h1 class="display-5 text-uppercase text-white mb-0">Save 50% on all items your first order</h1>
                    </div>
                    <p class="text-white mb-4">Eirmod sed tempor lorem ut dolores sit kasd ipsum. Dolor ea et dolore et at sea ea at dolor justo ipsum duo rebum sea. Eos vero eos vero ea et dolore eirmod et. Dolores diam duo lorem. Elitr ut dolores magna sit. Sea dolore sed et.</p>
                    <a href="" class="btn btn-light py-md-3 px-md-5 me-3">Shop Now</a>
                    <a href="" class="btn btn-outline-light py-md-3 px-md-5">Read More</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->    
    <?php include 'inc/footer.php'; ?>
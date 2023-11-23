<?php
require_once 'inc/header.php';
require_once 'db/db.php';
require_once 'db/product_cart.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$data = new db();
$search = $_GET['search'];
$results = $data->getResult($search);
$email = $_SESSION['email'];
?>

<!-- Search Start -->
<div class="container-fluid py-5">
    <div class="container">
        <div class="border-start border-5 border-primary ps-5 mb-5" style="max-width: 600px;">
            <h6 class="text-primary text-uppercase">Search</h6>
            <h1 class="display-5 text-uppercase mb-0">Searching For <?php echo $search; ?></h1>
        </div>
        <div class="owl-carousel product-carousel">
            <?php if (count($results) > 0) {
                foreach ($results as $product) { // Use $product instead of $result
            ?>
                <div class="pb-5">
                    <form method="POST" action="">
                        <div class="product-item position-relative bg-light d-flex flex-column text-center">
                            <img class="img-fluid mb-4" src="<?php echo $product['image']; ?>" alt="">
                            <h6 class="text-uppercase"><?php echo $product['name']; ?></h6>
                            <h6 class="text-lowercase"><?php echo $product['body']; ?></h6>
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
            <?php } // End of foreach loop
            } else {
                echo '<script>window.location.href = "404.php";</script>';
                exit;
            }?>
        </div>
    </div>
</div>
<!-- Search End -->
<?php require_once 'inc/footer.php'; ?>

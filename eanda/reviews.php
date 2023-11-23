<?php
include 'inc/header.php';
require_once 'db/reviews_orders.php';
require_once 'db/db.php';
require_once 'classes/product.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Retrieve the user's name from the session
$email = $_SESSION['email'];

$data = new db();
$review_info = $data->review_orders('review');

$table = 'customer';
$column = 'email';

$customerInfo = $data->getCustomerByEmail($table, $column, $email);
if ($customerInfo) {
    $name = $customerInfo['name'];
    $phone = $customerInfo['phone'];
    $city = $customerInfo['city'];
    $password = $customerInfo['password'];
    // Display other customer information as needed
} else {
    echo "Customer information not found.";
}

?>

<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">
                <br><br>
                <h2>Review your order</h2>
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
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>

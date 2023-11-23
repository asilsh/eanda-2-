<?php
include 'inc/header.php';
require_once 'db/product_cart.php';
require_once 'db/db.php';
require_once 'classes/product.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Retrieve the user's name from the session
$email = $_SESSION['email'];

$data = new db();
$wishlist_array = $data->customer_wishlist('customer', $email);

foreach ($wishlist_array as $row) {
    $id_p = $row['id_p'];
}

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
                <h2>Your Wishlist</h2>
                <form method="POST">
                    <div class="table-responsive custom-table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($wishlist_array as $row) {
                                    $id_p = $row['id_p'];
                                    $product_info = $data->getProductByID('product', 'id_p', $id_p);

                                    if ($product_info) {
                                ?>
                                    <tr scope="row">
                                        <td><a href="preview.php?id_p=<?php echo $id_p; ?>"><?php echo $product_info['name']; ?></a></td>
                                        <td>$<?php echo $product_info['price']; ?></td>
                                        <td><a href="preview.php?id_p=<?php echo $id_p; ?>">
                                            <img src="<?php echo $product_info['image']; ?>" 
                                                style="width: 100px; height: 100px;">
                                            </a>
                                        </td>
                                        <td>
                                        <a href="preview.php?id_p=<?php echo $id_p; ?>" class="btn btn-primary btn-lg" style="width: 100px; margin-right: 10px;">
                                            Cart
                                        </a>                                        
                                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100px; margin-right: 10px;" name="delete_wishlist" value="<?php echo $id_p; ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <br><br>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>

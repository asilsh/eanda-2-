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
$id_o = $_GET['id_o'];

$data = new db();
$order_info = $data->order_product('order', $id_o);

$id_p_array = array();
foreach ($order_info as $row) {
    $id_p_values = explode(',', $row['id_p']); // Split the comma-separated IDs
    foreach ($id_p_values as $id_p) {
        $id_p_array[] = $id_p;
    }
}

$table = 'customer';
$column = 'email';

$customerInfo = $data->getCustomerByEmail($table, $column, $email);
if (!$customerInfo) {
    echo "Customer information not found.";
    exit(); // Exit to prevent further code execution
}

$name = $customerInfo['name'];
$phone = $customerInfo['phone'];
$city = $customerInfo['city'];
$password = $customerInfo['password'];

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
                                <?php foreach ($id_p_array as $id_p) {
                                    $product_info = $data->getProductByID('product', 'id_p', $id_p);

                                    if ($product_info) {
                                        ?>
                                        <tr scope="row">
                                            <td><a href="#"><?php echo $id_p; ?></a></td> <!-- Print the ID -->
                                            <td><?php echo $product_info['name']; ?></td>
                                            <td>
                                                <img src="<?php echo $product_info['image']; ?>" 
                                                    style="width: 100px; height: 100px;">
                                            </td>
                                            <td>
                                                <textarea name="review_text[]" placeholder="Enter your review" rows="4" cols="50"></textarea>
                                                <input type="hidden" name="item_name[]" value="<?php echo $product_info['name']; ?>">
                                                <input type="hidden" name="item_id[]" value="<?php echo $id_p; ?>"> <!-- Add a hidden input for the item ID -->
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                }
                                ?>

                                <tr> <!-- Add a new row for the Review button -->
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>
                                        <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" name="review">Review</button>
                                    </td>
                                </tr>
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

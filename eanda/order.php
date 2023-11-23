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
$id_cus = $data->customer_id('customer', 'email', $email);
$customer_orders = $data->customer_orders('order', $id_cus);

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
                <br><br>
                <h2>Your Orders</h2>
                <form method="POST">
                    <div class="table-responsive custom-table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">Amount of products</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($customer_orders as $row) {
                                    $id_o = $row['id_o'];
                                    $product_info = $data->getOrderByID('`order`', 'id_o', $id_o);                                    
                                    if ($product_info) {
                                ?>
                                    <tr scope="row">
                                        <td><a href="#"><?php echo $product_info['id_o']; ?></a></td>
                                        <td><?php echo $product_info['amount']; ?></td>
                                        <td><?php echo $product_info['status']; ?></td>
                                        <td>
                                            <a href="recived_order.php?id_o=<?php echo $id_o; ?>" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;">Received</a>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                }
                                ?>
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

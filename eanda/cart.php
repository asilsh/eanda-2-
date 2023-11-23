<?php
include 'inc/header.php';
require_once 'db/product_cart.php';
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
$cart_info = $data->customer_cart('cart', $email);

foreach ($cart_info as $row) {
    $id_p = $row['id_p'];
    $product_info = $data->getProductByID('product', 'id_p', $id_p);
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
                <br><br>
                <h2>Your Cart</h2>
                <form method="POST">
                    <div class="table-responsive custom-table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Name</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Size</th>
                                    <th scope="col">Amount</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cart_info as $row) {
                                    $id_p = $row['id_p'];
                                    $product_info = $data->getProductByID('product', 'id_p', $id_p);

                                    if ($product_info) {
                                ?>
                                    <tr scope="row">
                                        <td><a href="#"><?php echo $product_info['name']; ?></a></td>
                                        <td>$<?php echo $product_info['price']; ?></td>
                                        <td>
                                            <img src="<?php echo $product_info['image']; ?>" 
                                                style="width: 100px; height: 100px;">
                                        </td>
                                        <td><?php echo $row['size']; ?></td>
                                        <td><?php echo $row['amount']; ?></td>
                                        <td>
                                            <button type="submit" class="btn btn-primary btn-lg" style="width: 100px; margin-right: 10px;" name="delete_cart" value="<?php echo $id_p; ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                } ?>
                            </tbody>
                        </table>
                        <br><br>
                        <style>
                            .center {
                                display: flex;
                                justify-content: center;
                                align-items: center;
                            }
                        </style>
                        <div class="center">
                            <?php  
                            $data = new db();
                            $amount_product = $data->amount_product('cart', 'amount');
                            echo "Amount Products: " . $amount_product;  
                            echo "<br>";
                            $amount_price = $data->sum_price('cart', 'price', 'amount');
                            echo "Total Price: $" . $amount_price;
                            $_SESSION['amount_price'] = $amount_price;
                            ?>
                        </div>
                    </div>
                </form>
                <br><br>
                <section class="vh-100">
                    <div class="container-fluid h-custom">
                        <div class="row d-flex justify-content-center align-items-center h-100">
                            <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                                <!-- Name input -->
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Full-Name</label>
                                    <input type="text" name="name" id="form3Example3" class="form-control form-control-lg"
                                        value="<?php echo $name; ?>" readonly/>
                                </div>

                                <!-- Phone input -->
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Phone number</label>
                                    <input type="text" name="phone" id="form3Example3" readonly oninput="this.value = this.value.replace(/[^0-9]/g, '')" class="form-control form-control-lg"
                                        value="<?php echo $phone; ?>" readonly/>
                                </div>

                                <!-- City input -->
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">City</label>
                                    <input type="text" name="city" id="form3Example3" class="form-control form-control-lg" 
                                        value="<?php echo $city; ?>" readonly/>
                                </div>

                                <!-- Email input -->
                                <div class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Email</label>
                                    <input type="text" name="email" id="form3Example3" class="form-control form-control-lg" 
                                        value="<?php echo $email; ?>" readonly/>
                                </div>
                                <div class="clear"></div>
                                <div class="text-center text-lg-start mt-4 pt-2">
                                <form method="POST">
                                    <button type="submit" class="btn btn-primary btn-lg" style="padding-left: 2.5rem; padding-right: 2.5rem;" name="payOnline">Pay Online</button>
                                    <button type="submit" class="btn btn-primary btn-lg"
                                        style="padding-left: 2.5rem; padding-right: 2.5rem;" name="pay">Pay Offline</button>
                                </form>
                            </div>  
                            </div>
                        </div>
                    </div>
                </section>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>

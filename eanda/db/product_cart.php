<?php
$filepath = __DIR__;
require_once($filepath . '/../classes/product.php');
require_once($filepath . '/db.php');

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// From insertProduct.php file - to updtae new product
if (isset($_POST["update"])) {
    $id_p = $_POST['id_p'];
    $name = $_POST['name'];
    $body = $_POST['body'];
    $price = $_POST['price'];
    $size_s = $_POST['s'];
    $size_m = $_POST['m'];
    $size_l = $_POST['l'];
    $inventory = $size_s + $size_m + $size_l;

    echo '<script>alert("inventory: "'.$inventory.');</script>';

    $data = new db();

    $columns = ['id_p', 'name', 'body', 'price', 'inventory'];
    $values = [$id_p, $name, $body, $price, $inventory];

    if ($data->check_if_exist('product', 'id_p', $id_p)) {
        if ($data->update_product('product', $columns, $values, $id_p)) {
            if($inventory <= 0){
                $data->update_product_status($id_p, 'Out of Stock');
            } else {
                $data->update_product_status($id_p, 'available');
            }
        }
        $data->update_product_size('product', $id_p, $size_s, $size_m, $size_l);
        if($size_s > 0){
            $data->update_product_status_size($id_p, 'available', 'status_s');
        } else {
            $data->update_product_status_size($id_p, 'Out of Stock', 'status_s');
        }
        if($size_m > 0){
            $data->update_product_status_size($id_p, 'available', 'status_m');
        } else {
            $data->update_product_status_size($id_p, 'Out of Stock', 'status_m');
        }
        if($size_l > 0){
            $data->update_product_status_size($id_p, 'available', 'status_l');
        } else {
            $data->update_product_status_size($id_p, 'Out of Stock', 'status_l');
        }
        echo '<script>alert("Product has been updated");</script>';
    }
}

// From insertProduct.php file - to update/delete product from cart
if (isset($_POST["delete"])) {
    $id_p = $_POST['id_p'];

    $data = new db();
    if ($data->delete_product('product', $id_p)) {
        echo '<script>alert("Product has been deleted");</script>';
        echo '<script>window.location.href = "insertProduct.php";</script>';
        exit;
    }
}

// From insertProduct.php file - to update id_o after paying
if (isset($_POST["payOnline"])) {
    echo '<script>window.location.href = "payOnline.php";</script>';
    exit;
}

// From insertProduct.php file - to update id_o after paying
if (isset($_POST["pay"])) {
    $data = new db();
    $email = $_SESSION['email'];
    $amount_price = $_SESSION['amount_price'];

    // Function returns id_o from order table
    $id_o = $data->get_max_id('order', 'id_o');

    // Update id_o to customer
    $data->update_order('customer', $email, $id_o);
    $id_cus = $data->customer_id_by_email('customer', $email);

    // Get id_p and amount arrays from cart
    $id_p_array = $data->get_data('cart', $id_cus, 'id_p');
    $id_p_string = implode(',', $id_p_array);

    $amount_array = $data->get_data('cart', $id_cus, 'amount');
    $amount_string = implode(',', $amount_array);

    $size_array = $data->get_data('cart', $id_cus, 'size');
    $size_string = implode(',', $size_array);


    $status = 'Request';
    $date = date('Y-m-d H:i:s');
    $start = '2023-01-01 00:00:00';
    $end = '2023-01-01 00:00:00';
    $id_w = 0;

    // Column names and values for insertion
    $column_array = ['id_o', 'id_cus', 'id_p', 'amount', 'status', 'date', 'start', 'end', 'id_w', 'amount_price'];
    $values_array = [$id_o, $id_cus, $id_p_string, $amount_string, $status, $date, $start, $end, $id_w, $amount_price];
    
    if ($data->insert_order('order', $column_array, $values_array)) {
        $data->decrement_products($id_o);
        $data->decrement_products_size($amount_string, $size_string, $id_p_string);
        // Clear the cart and set session variable
        $data->delete_cart('cart');
        $_SESSION['id_o'] = $id_o;
        
        // Redirect to the payOffline page
        echo '<script>window.location.href = "payOffline.php";</script>';
        exit;
    }
}

// From insertProduct.php file - to insert new product
if (isset($_POST["insert"])) {
    $data = new db();

    $name = $_POST['name'];
    $body = $_POST['body'];
    $price = $_POST['price'];
    $inventory = $_POST['inventory'];
    $gender = $_POST['gender'];
    $clothing_jewelry = $_POST['clothing_jewelry'];
    $image = 'img/' . $_POST['image'];
    $status = "available";

    // Get the maximum ID value
    $id = $data->get_max_id('product', 'id_p');

    // Define the column names and values
    $columns = ['id_p', 'name', 'body', 'price', 'image', 'inventory', 'gender', 'clothing_jewelry', 'status'];
    $values = [$id, $name, $body, $price, $image, $inventory, $gender, $clothing_jewelry, $status];
    
    // Check if any of the columns in $values are empty
    foreach ($values as $value) {
        if (empty($value)) {
            echo '<script>window.location.href = "insertProduct.php";</script>';
            echo '<script>alert("Need to enter info of the products");</script>';
        }
    }

    // Insert data into the database
    $data->insert_data('product', $columns, $values);
}

// From preview.php file - to add product to cart
if (isset($_POST["cart"])) {
    // Perform necessary actions for adding to cart
    $email = $_SESSION['email'];
    $id_p = $_GET['id_p'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];

    $data = new db(); 
    
    $price = $data->product_price('product', $id_p);
    $id_cus = $data->customer_id_by_email('customer', $email);

    $db_quantity = $data->get_quantity('product', $id_p);
    $total = $db_quantity - $quantity;

    $check_cart = $data->check_duplicates('cart', $id_p);

    if(!$data->status_sold_out('product', $id_p, $size)){
        if($total >= 0){
            if($check_cart){
                if ($data->save_product($id_cus, $id_p, $quantity, $price, $size)) {
                    echo '<script>alert("The product has been successfully added to the cart.");</script>';
                } else {
                    echo '<script>alert("Something went wrong!");</script>';
                }
            } else {
            echo '<script>alert("Sorry, You cannot this profuct, already exists in cart");</script>';
        }
        } else {
            echo '<script>alert("Sorry, You cannot order more than ' . $db_quantity . ' products");</script>';
        }
    } else {
        echo '<script>alert("Sorry, This product has sold out");</script>';
    }
}

// From Product.php file - to add product to cart
if (isset($_POST["fullscreen"])) {
    // Perform necessary actions for adding to cart
    $email = $_SESSION['email'];
    $name = $_POST['name'];
    $body = $_POST['body'];
    
    $data = new db(); 
    
    $id_p = $data->product_id('product', $name, $body);
    echo "<script>window.location.href = 'preview.php?id_p=$id_p';</script>";
}

// From Preview.php file - to add product to wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['star'])) {

        $id_p = $_GET['id_p'];
        $email = $_SESSION['email'];

        $data = new db(); 

        if($data->wishlist_product($email, $id_p)){
            echo '<script>alert("The product has been successfully added to the wishlist.");</script>';
        } else {
            echo '<script>alert("The product is already in wishlist.!");</script>';
        }
    }
}


// From wishlist.php file - to delete product from wishlist
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_wishlist'])) {
        $id_p = $_POST['delete_wishlist'];
        $email = $_SESSION['email'];

        $data = new db(); 

        $id_cus = $data->customer_id_by_email('customer', $email);
        if($data->wishlist_product_delete($id_cus, $id_p)){
            echo '<script>alert("The product has been successfully removed from wishlist.");</script>';
        } else {
            echo '<script>alert("Something went wrong!");</script>';
        }
    }
}

// From cart.php file - to delete product from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['delete_cart'])) {
        $id_p = $_POST['delete_cart'];
        $email = $_SESSION['email'];

        $data = new db(); 

        $id_cus = $data->customer_id_by_email('customer', $email);
        if($data->cart_product_delete($id_cus, $id_p)){
            echo '<script>alert("The product has been successfully removed from cart.");</script>';
        } else {
            echo '<script>alert("Something went wrong!");</script>';
        }
    }
}

// From cart.php file - to change status "sold out" of product from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['sold_out'])) {
        $id_p = $_POST['sold_out'];

        // Sanitize the input using intval
        $id_p = intval($id_p);

        $data = new db(); 

        if($data->sold_out($id_p)){
            echo '<script>alert("The product has been successfully changed to sold out.");</script>';
        } else {
            echo '<script>alert("Something went wrong!");</script>';
        }
    }
}


// From cart.php file - to change status "suspended" of product from cart
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['suspended'])) {
        $id_p = $_POST['suspended'];

        $data = new db(); 

        if($data->suspended($id_p)){
            echo '<script>alert("The product has been successfully changed to suspended.");</script>';
        } else {
            echo '<script>alert("Something went wrong!");</script>';
        }
    }
}
?>

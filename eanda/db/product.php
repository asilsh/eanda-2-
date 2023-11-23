<?php
$filepath = __DIR__;
require_once($filepath . '/../classes/product.php');
require_once($filepath . '/db.php');

// From insertProduct.php file - to updtae new product
if (isset($_POST["update"])) {
    $id_p = $_POST['id_p'];
    $name = $_POST['name'];
    $body = $_POST['body'];
    $price = $_POST['price'];
    $inventory = $_POST['inventory'];
    echo '<script>alert("Product has been updated");</script>';

    $data = new db();

    $columns = ['id_p', 'name', 'body', 'price', 'inventory'];
    $values = [$id_p, $name, $body, $price, $inventory];

    if ($data->check_if_exist('product', 'id_p', $id_p)) {
        if ($data->update_product('product', $columns, $values, $id_p)) {
            echo '<script>alert("Product has been updated");</script>';
        }
    }
}

// From insertProduct.php file - to updtae new product
if (isset($_POST["delete"])) {
    $id_p = $_POST['id_p'];

    $data = new db();
    if ($data->delete_product('product', $id_p)) {
        echo '<script>alert("Product has been deleted");</script>';
        echo '<script>window.location.href = "insertProduct.php";</script>';
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

    // Get the maximum ID value
    $id = $data->get_max_id('product', 'id_p');

    // Define the column names and values
    $columns = ['id_p', 'name', 'body', 'price', 'image', 'inventory', 'gender', 'clothing_jewelry'];
    $values = [$id, $name, $body, $price, $image, $inventory, $gender, $clothing_jewelry];
    
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
?>
<?php

$filepath = __DIR__;
require_once($filepath . '/../classes/customer.php');
require_once($filepath . '/../classes/admin.php');
require_once($filepath . '/../classes/worker.php');
require_once($filepath . '/db.php');

// From register.php file - to insert new customer
if (isset($_POST["register"])) {
    $data = new db();

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $column = 'email';

    if ($data->check_if_exist('customer', $column, $email)) {
        echo '<script>alert("This mail already exists");</script>';
        exit; // Make sure to exit after the header redirect
    } else {
        $column_array = ['id_cus', 'name', 'email', 'password', 'city', 'phone', 'id_o'];
        $values_array = [$data->get_max_id('customer', 'id_cus'), $name, $email, $password, $city, $phone, '0'];
        if($data->check_phone($phone, 'customer')){
            if ($data->insert_data('customer', $column_array, $values_array)) {
                echo '<script>alert("Account has been created successfully");</script>';
            } else {
                echo '<script>alert("Something went wrong, try again later");</script>';
            }
        } else {
            echo '<script>alert("Phone Number is not right");</script>';
        }
    }
}

// From login.php file - to check if customer exist in db
if (isset($_POST["login"])) {
    $data = new db();

    $email = $_POST['email'];
    $password = $_POST['password'];
    $column = 'email';

    if ($data->check_login('customer', $email, $password)) {
        // Set session variable indicating user is logged in
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        echo '<script>alert("Welcome!"); window.location.href = "index.php";</script>';
        exit;    
    } else if ($data->check_login('admin', $email, $password)) {
        $_SESSION['loggedin'] = true;
        $_SESSION['isAdmin'] = true;
        $_SESSION['email'] = $email;
        echo '<script>alert("Welcome Admin!"); window.location.href = "statsProducts.php";</script>';
        exit;
    } else if ($data->check_login('worker', $email, $password)) {
        // Set session variable indicating user is logged in
        $_SESSION['loggedin'] = true;
        $_SESSION['email'] = $email;
        echo '<script>alert("Welcome Worker!"); window.location.href = "orders.php";</script>';
        exit;
    } else{
        echo '<script>alert("Account is not registered!"); window.location.href = "register.php";</script>';
    }
}

// From header.php file - to let the customer logout
if (isset($_POST["logout"])) {
    // Destroy the session and redirect to login page
    session_destroy();
    // Redirect to the login page after logout
    echo '<script>window.location.href = "login.php";</script>';
    exit;
}

// From about.php file - to update customer info
if (isset($_POST["update"])) {
    $data = new db();

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $id_cus = $data->customer_id('customer', 'email', $email);

    if ($id_cus) {
        $column_array = ['id_cus', 'name', 'email', 'password', 'city', 'phone', 'id_o'];
        $values_array = [$id_cus, $name, $email, $password, $city, $phone, '0'];
        if ($data->updateCustomer('customer', $column_array, $values_array, $email)) {
            echo '<script>alert("Account has been updated successfully");</script>';
        } else {
            echo '<script>alert("Something went wrong, try again later");</script>';
        }
        echo '<script>window.location.href = "' . $_SERVER['PHP_SELF'] . '";</script>';
        exit; // Make sure to exit after the header redirect
    }
}

// From about.php file - to update customer info
if (isset($_POST["reset"])) {
    $data = new db();
    
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];
    
    echo '<script>alert("email: ' . $email . ', phone: ' . $phone . '");</script>';    

    if ($data->check_login_reset('customer', $email, $phone)) {
        echo '<script>alert("Hello hello reset");</script>';
        if($data->update_password('customer', $email, $password)){
            echo '<script>alert("Passowrd has been changed");</script>';
            echo '<script>window.location.href = "login.php";</script>';
            exit;
        } else {
            echo '<script>alert("Something went wrong, try again later");</script>';
        }
    }
}

?>

<?php

$filepath = __DIR__;
require_once($filepath . '/../classes/customer.php');
require_once($filepath . '/db.php');

// From register.php file - to insert new 'customer'
if (isset($_POST["insert"])) {
    $data = new db();

    $email = $_POST['email'];
    $name = $_POST['name'];
    $password = $_POST['password'];
    $city = $_POST['city'];
    $phone = $_POST['phone'];
    $column = 'email';

    if ($data->check_if_exist('worker', $column, $email)) {
        echo '<script>alert("This mail already exists");</script>';
        exit; // Make sure to exit after the header redirect
    } else {
        $column_array = ['id_w', 'name', 'email', 'password', 'city', 'phone', 'id_o'];
        $values_array = [$data->get_max_id('worker', 'id_w'), $name, $email, $password, $city, $phone, '0'];
        if($data->check_phone($phone, 'worker')){
            if ($data->insert_data('worker', $column_array, $values_array))
            {
                echo '<script>alert("Account has been created successfully");</script>';
            }
        } else {
            echo '<script>alert("Something went wrong, try again later");</script>';
        }
    }
}
?>

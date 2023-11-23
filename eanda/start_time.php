<?php
include 'inc/header.php';
require_once 'db/db.php';
require_once 'classes/product.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$data = new db();

// Retrieve the user's name from the session
$email = $_SESSION['email'];
$id_w = $data->getWorkerIDByEmail('worker', 'email', $email);

if (isset($_GET["id_o"])) {
    $id_o = $_GET["id_o"];
    echo '<script>alert("' . $id_o . '");</script>';
    $datetime = date('Y-m-d H:i');

    $data->update_time('order', 'start', $datetime, $id_o);
    $data->update_time('order', 'id_w', $id_w, $id_o);
    if($data->update_worker_id_o('worker', $id_o, $email)){
        echo '<script>alert("' . $email . ' Took order number ' . $id_o .'");</script>';
    }
}

?>

<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">
                <br><br>
                <h2 style="text-align: center;">Time has started</h2>
                <br><br>
                <div style="text-align: center;">
                    Order ID # <?php echo $id_o; ?> Taken by Worker # <?php echo $id_w; ?>
                    <br><br>
                    Start Time: <?php echo date('H:i', strtotime($datetime)); ?>
                    <br><br>
                    <button class="btn btn-primary end-btn" onclick="window.location.href='orders.php'">List of orders</button>
                </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>
<?php
include 'inc/header.php';
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
echo '<script>alert("' . $email . '");</script>';

$data = new db();
$id_w = $data->getWorkerIDByEmail('worker', 'email', $email);
$order_info = $data->all_orders('order', $id_w);

if (isset($_GET["id_o"])) {
    $id_o = $_GET["id_o"];
    echo '<script>alert("' . $id_o . '");</script>';
}

?>

<div class="main">
    <div class="content">
        <div class="cartoption">
            <div class="cartpage">
                <br><br>
                <h2>Orders</h2>
                <br>
                <form method="POST">
                    <div class="table-responsive custom-table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Date</th>
                                    <th scope="col">Start</th>
                                    <th scope="col">End</th>
                                    <th scope="col">Worker ID</th>
                                    <th scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_info as $row) { ?>
                                    <tr scope="row">
                                        <td><a href="#"><?php echo $row['id_o']; ?></a></td>
                                        <td><?php echo $row['status']; ?></td>
                                        <td><?php echo date('H:i', strtotime($row['date'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($row['start'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($row['end'])); ?></td>
                                        <td><?php echo $row['id_w']; ?></td>
                                        <td>
                                        <?php
                                            if ($row['status'] === "Has been reviewed" || $row['status'] === "Shipped") {
                                                echo '<form class="nav-item" action="login.php" method="post">';
                                                // Any content you want to put inside the form
                                                echo '</form>';
                                            } else {
                                                $id_o = $row['id_o'];
                                                
                                                echo '<div class="d-flex gap-3">';
                                                echo '<a class="btn btn-primary start-btn" href="start_time.php?id_o=' . $id_o . '&email=' . $email . '">Start</a>';
                                                echo '<a class="btn btn-primary start-btn" href="end_time.php?id_o=' . $id_o . '&email=' . $email . '">End</a>';
                                                echo '</div>';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
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
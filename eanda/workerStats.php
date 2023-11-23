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

$data = new db();

// Retrieve the user's name from the session
$email = $_SESSION['email'];
echo '<script>alert("' . $email . '");</script>';
$id_w = $data->getWorkerIdByEmail('worker', 'email', $email);

$order_info = $data->all_orders_shipped('order');

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
                <h2>Worker Stats</h2>
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
                            $id_w = $data->best_worker('order');
                            echo $id_w;                       
                            ?>
                            <br><br>
                        </div>
                <form method="POST">
                    <div class="table-responsive custom-table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr>
                                    <th scope="col">Worker Name</th>
                                    <th scope="col">Order Number</th>
                                    <th scope="col">Start</th>
                                    <th scope="col">End</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($order_info as $row) { ?>
                                    <tr scope="row">
                                        <td><a href="#"><?php 
                                                $worker_name = $data->getWorkerName('worker', $row['id_w']);
                                                echo $worker_name; 
                                            ?></a></td>
                                        <td><?php echo $row['id_o']; ?></td>
                                        <td><?php echo date('H:i', strtotime($row['start'])); ?></td>
                                        <td><?php echo date('H:i', strtotime($row['end'])); ?></td>
                                        <td><?php
                                        
                                        $startDateTime = new DateTime($row['start']);
                                        $endDateTime = new DateTime($row['end']);

                                        // Calculate the time difference
                                        $timeDifference = $startDateTime->diff($endDateTime);

                                        // Get the days, hours, minutes, and seconds from the time difference
                                        $days = $timeDifference->format('%a');
                                        $hours = $timeDifference->format('%H');
                                        $minutes = $timeDifference->format('%I');

                                        // Output the time difference with days, hours, minutes, and seconds
                                        echo "$days days, $hours hours, $minutes minutes";
                                        
                                        ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </form>
                <br><br>
                <!-- Insert product end -->
                <br><br>
                <div class="d-inline-block">
                <!-- Worker's list button -->
                <form action="insertWorker.php" method="post">
                    <button type="submit" class="btn btn-primary btn-lg" style="width: 150px;">Worker's List</button>
                </form>
                </div>
                <div class="d-inline-block ml-2">
                    <!-- Insert Product button -->
                    <form action="insertProduct.php" method="post">
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 150px;">Insert Product</button>
                    </form>
                </div>
                <div class="d-inline-block ml-2">
                <!-- Worker's stats button -->
                <form action="statsProducts.php" method="post">
                    <button type="submit" class="btn btn-primary btn-lg" style="width: 150px;">Products's Stats</button>
                </form>
            </div>
                <div class="clear"></div>
            </div>
        </div>
    </div>
</div>
<?php include 'inc/footer.php'; ?>

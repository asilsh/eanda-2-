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

// Create a new instance of the db class
$data = new db();
$productDetails = $data->getProduct_soldout('product');
?>

<!-- List product Start -->
<br><br>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="fonts/icomoon/style.css">
<link rel="stylesheet" href="css/owl.carousel.min.css">
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="css/bootstrap.min.css">
<!-- Style -->
<link rel="stylesheet" href="css/style.css">
<script>
    function show_window(btn) {
        document.getElementById('event_update').style.display='block';
        document.getElementById("event_id").value = btn.id.split("_")[1];
    }
</script>



<title>Sold Out Product's Table</title>
</head>
<body>
    <div class="content">
        <div class="container">
            <h2 class="mb-5">Sold out product's Table</h2>
            <form method="POST" action="http://localhost/eanda/insertProduct.php">
            <div class="table-responsive custom-table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <!-- <th scope="col">Information</th>
                            <th scope="col">Price</th>
                            <th scope="col">Inventory</th> -->
                            <th scope="col">Image</th>
                            <th scope="col">Status</th>
                            <!-- <th scope="col">Actions</th> -->
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productDetails as $product) { ?>
                            <tr scope="row">
                            <td><?php echo $product['id_p']; ?></td>
                            <td><a href="insertProduct.php?id=<?php echo $product['id_p']; ?>"><?php echo $product['name']; ?></a></td>
                                
                                <!-- <td><?php echo $product['body']; ?></td>
                                <td>$<?php echo $product['price']; ?></td>
                                <td><?php echo $product['inventory']; ?></td> -->
                                <td>  <a href="insertProduct.php?id_p=<?php echo $product['id_p']; ?>">
                               <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['image']; ?>" style="width: 100px; height: 100px;"></td>
                                <td>
                                <td><?php echo $product['status']; ?></td>
                                <td>
                                <div class="text-center text-lg-start mt-4 pt-2">
                                <div style="display: inline-block;">
                                <input type="hidden" name="id_p" id="product_id" value="<?php echo $product['id_p']; ?>">
                                <!-- <button type="button" class="btn btn-primary btn-lg" style="width: 100px;" id="update_<?php echo $product['id_p']; ?>" name="update" 
                                onclick="updateProduct(<?php echo $product['id_p']; ?>)">Update</button> -->
                            </div>
                                </div>
                                <script>
                                    function updateProduct(productId) {
                                        // Construct the URL with the id_p parameter
                                        var url = 'http://localhost/eanda/updateProduct.php?id_p=' + productId;
                                        
                                        // Redirect the user to the next page
                                        window.location.href = url;
                                    }
                                </script>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </form>
<!-- List product End -->

<br><br><br><br>

<?php
$data = new db();

$dataPoints = array( 
    array("y" => $data->get_price('`order`', '1'), "label" => "January" ),
    array("y" => $data->get_price('`order`', '2'), "label" => "February" ),
    array("y" => $data->get_price('`order`', '3'), "label" => "March" ),
    array("y" => $data->get_price('`order`', '4'), "label" => "April" ),
    array("y" => $data->get_price('`order`', '5'), "label" => "May" ),
    array("y" => $data->get_price('`order`', '6'), "label" => "June" ),
    array("y" => $data->get_price('`order`', '7'), "label" => "July" ),
    array("y" => $data->get_price('`order`', '8'), "label" => "August" ),
    array("y" => $data->get_price('`order`', '9'), "label" => "September" ),
    array("y" => $data->get_price('`order`', '10'), "label" => "October" ),
    array("y" => $data->get_price('`order`', '11'), "label" => "November" ),
    array("y" => $data->get_price('`order`', '12'), "label" => "December" )
);

$dataPoints2 = array(
    array("y" => $data->get_amount_of_orders('`order`', '1'), "label" => "January" ),
    array("y" => $data->get_amount_of_orders('`order`', '2'), "label" => "February" ),
    array("y" => $data->get_amount_of_orders('`order`', '3'), "label" => "March" ),
    array("y" => $data->get_amount_of_orders('`order`', '4'), "label" => "April" ),
    array("y" => $data->get_amount_of_orders('`order`', '5'), "label" => "May" ),
    array("y" => $data->get_amount_of_orders('`order`', '6'), "label" => "June" ),
    array("y" => $data->get_amount_of_orders('`order`', '7'), "label" => "July" ),
    array("y" => $data->get_amount_of_orders('`order`', '8'), "label" => "August" ),
    array("y" => $data->get_amount_of_orders('`order`', '9'), "label" => "September" ),
    array("y" => $data->get_amount_of_orders('`order`', '10'), "label" => "October" ),
    array("y" => $data->get_amount_of_orders('`order`', '11'), "label" => "November" ),
    array("y" => $data->get_amount_of_orders('`order`', '12'), "label" => "December" )
);
 
?>
<script>
window.onload = function() {
    var chart = new CanvasJS.Chart("chartContainer", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: "Finances"
        },
        axisY: {
            title: "Finances (in year)"
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0.## ₪",
            dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart.render();

    var chart2 = new CanvasJS.Chart("chartContainer2", {
        animationEnabled: true,
        theme: "light2",
        title: {
            text: "Number of Orders"
        },
        axisY: {
            title: "Number of Orders"
        },
        data: [{
            type: "column",
            yValueFormatString: "#,##0 Orders",
            dataPoints: <?php echo json_encode($dataPoints2, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chart2.render();
}
</script>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<div id="chartContainer2" style="height: 370px; width: 100%;"></div>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</body>

<br><br>
<div class="container">
<form method="post">
    <h2 class="mb-5">Range</h2>
    <h5>Please choose from date to date:</h5>
    <label for="months">Choose a month from:</label>
        <select name="months_start" id="months">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>

        <label for="months">to:</label>
        <select name="months_end" id="months">
            <option value="1">January</option>
            <option value="2">February</option>
            <option value="3">March</option>
            <option value="4">April</option>
            <option value="5">May</option>
            <option value="6">June</option>
            <option value="7">July</option>
            <option value="8">August</option>
            <option value="9">September</option>
            <option value="10">October</option>
            <option value="11">November</option>
            <option value="12">December</option>
        </select>

        <!-- Range button -->
        <div style="display: inline-block; margin-right: 10px;">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 100px;" name="range">Submit</button>
        </div>
    </form>

    <?php 
        if (isset($_POST["range"])) {
            $selectedMonthStart = $_POST["months_start"];
            $selectedMonthEnd = $_POST["months_end"];

            if($selectedMonthStart >= $selectedMonthStart){
                if($selectedMonthStart <= 9){
                    $selectedMonthStart = "2023-0".$selectedMonthStart."-01";
                } else {
                    $selectedMonthStart = "2023-".$selectedMonthStart."-01";
                }
                if($selectedMonthEnd <= 9){
                    $selectedMonthEnd = "2023-0".$selectedMonthEnd."-31";
                } else {
                    $selectedMonthEnd = "2023-".$selectedMonthEnd."-31";
                }
                
                $data = new db();
                $amount_payment = $data->get_order_amout_price_dates('order', 'amount_price', $selectedMonthStart, $selectedMonthEnd);
                $amount_orders = $data->get_order_amout_orders_dates('order', 'id_o', $selectedMonthStart, $selectedMonthEnd);
                ?>
                
                <h6>
                    <?php
                    if ($amount_payment || $amount_orders) {
                        if ($amount_payment) {
                            echo "Total Amount: " . $amount_payment ."<br>";
                        }
                        if ($amount_orders) {
                            echo "Total Orders: " . $amount_orders;
                        }
                    } else {
                        echo "There were no orders between these dates";
                    }
                    ?>
                </h6>                
            <?php    
            }else{
                echo '<script>alert("Sorry you can not choose month like that");</script>';
            }
        }
    ?>
    
    
        
</div>

<br><br>

        <br><br>
        <div class="d-inline-block">
      <!-- Worker's list button -->
        <form action="insertWorker.php" method="post">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 150px;">Worker's List</button>
        </form>
    </div>
    <div class="d-inline-block ml-2">
        <!-- Worker's stats button -->
        <form action="workerStats.php" method="post">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 150px;">Worker's Stats</button>
        </form>
    </div>
    <div class="d-inline-block ml-2">
                <!-- Insert product button -->
                <form action="insertProduct.php" method="post">
                    <button type="submit" class="btn btn-primary btn-lg" style="width: 150px;">Insert Product</button>
                </form>
            </div>
        </div>
    </div>

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
    <!-- Insert product End -->
    <?php
    include 'inc/footer.php';
    ?>
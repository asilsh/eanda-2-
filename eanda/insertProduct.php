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
$productDetails = $data->getProduct('product');
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

<title>Product Table</title>
</head>
<body>
    <div class="content">
        <div class="container">
            <h2 class="mb-5">Product Table</h2>
            <form method="POST" action="http://localhost/eanda/insertProduct.php">
            <div class="table-responsive custom-table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Information</th>
                            <th scope="col">Price</th>
                            <th scope="col">Inventory</th>
                            <th scope="col">S</th>
                            <th scope="col">M</th>
                            <th scope="col">L</th>
                            <th scope="col">Image</th>
                            <th scope="col">Status S</th>
                            <th scope="col">Status M</th>
                            <th scope="col">Status L</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productDetails as $product) { ?>
                            <tr scope="row">
                            <td><?php echo $product['id_p']; ?></td>
                                <td><a href="#"><?php echo $product['name']; ?></a></td>
                                <td><?php echo $product['body']; ?></td>
                                <td>$<?php echo $product['price']; ?></td>
                                <td><?php echo $product['inventory']; ?></td>
                                <td><?php echo $product['s']; ?></td>
                                <td><?php echo $product['m']; ?></td>
                                <td><?php echo $product['l']; ?></td>
                                <td>
                                    <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['image']; ?>" style="width: 100px; height: 100px;">
                                </td>
                                <!-- <td><?php echo $product['status']; ?></td> -->
                                <td><?php echo $product['status_s']; ?></td>
                                <td><?php echo $product['status_m']; ?></td>
                                <td><?php echo $product['status_l']; ?></td>
                                <td>
                                <div class="text-center text-lg-start mt-4 pt-2">
                                <div style="display: inline-block;">
                                <input type="hidden" name="id_p" id="product_id" value="<?php echo $product['id_p']; ?>">
                                <button type="button" class="btn btn-primary btn-lg" style="width: 100px;" id="update_<?php echo $product['id_p']; ?>" name="update" 
                                    onclick="updateProduct(<?php echo $product['id_p']; ?>)">Update</button>
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
<!-- Insert product Start -->
            <form method="POST">
            <!-- Name input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Product Name</label>
            <input type="text" name="name" id="form3Example3" class="form-control form-control-lg"
              placeholder="Product Name" required />
          </div>
          <!-- Information input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Information</label>
            <input type="text" name="body" id="form3Example3" class="form-control form-control-lg"
              placeholder="Information" required />
          </div>
          <!-- Price input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Price</label>
            <input type="text" name="price" id="form3Example3" class="form-control form-control-lg"
              placeholder="Price" required />
          </div>
          <!-- Inventory input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="form3Example3">Inventory</label>
            <input type="text" name="inventory" id="form3Example3" class="form-control form-control-lg"
              placeholder="Inventory" required/>
          </div>
          <!-- Gender input -->
          <div class="form-outline mb-4">
          <label class="form-label" for="genderSelect">Gender</label>
            <select name="gender" id="genderSelect" class="form-select form-select-lg" required>
                <option value="Woman">Woman</option>
                <option value="Men">Men</option>
                <option value="Kids">Kids</option>
            </select>
          </div>
        <!-- Type input -->
        <div class="form-outline mb-4">
            <label class="form-label" for="typeSelect">Type</label>
            <select name="clothing_jewelry" id="typeSelect" class="form-select form-select-lg" required>
                <option value="dress">Dress</option>
                <option value="t-shirt">T-Shirt</option>
                <option value="pants">Pants</option>
                <option value="necklaces">Necklaces</option>
                <option value="rings">Rings</option>
                <option value="bracelets">Bracelets</option>
            </select>
        </div>
          <!-- Image input -->
          <div class="form-outline mb-4">
            <label class="form-label" for="imageUpload">Image</label>
            <input type="file" name="image" id="imageUpload" class="form-control form-control-lg" accept="image/*" required />
          </div>
          <!-- Insert button -->
          <div style="display: inline-block; margin-right: 10px;">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 100px;" name="insert">Insert</button>
          </div>
        </form>
        <!-- Insert product end -->
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
        <!-- Worker's stats button -->
        <form action="statsProducts.php" method="post">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 150px;">Products's Stats</button>
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
<?php
include 'inc/header.php';
require_once 'db/worker.php';
require_once 'db/db.php';

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Create a new instance of the db class
$data = new db();

$workerInfo=$data->all_workers('worker');

?>
<!-- Insert worker Start -->
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
<title>Worker Table</title>
</head>
<body>
    <div class="content">
        <div class="container">
            <h2 class="mb-5">Worker Table</h2>
            <!-- List Worker Start -->  
            <form method="POST">
            <div class="table-responsive custom-table-responsive">
                <table class="table custom-table">
                    <thead>
                        <tr>
                            <th scope="col">Worker ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($workerInfo as $worker) { ?>
                            <tr scope="row">
                            <td><a href="#"><?php echo $worker['id_w']; ?></a></td>
                                <td><?php echo $worker['name']; ?></td>
                                <td><?php echo $worker['email']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            </form>
            <!-- List Worker End -->  
            <br>
            <h2>Insert Worker</h2>
            <br>
            <!-- Insert Worker Start -->
            <form method="POST">
                        <!-- Name input -->
                      <div class="form-outline mb-4">
                      <label class="form-label" for="form3Example3">Worker Name</label>
                        <input type="text" name="name" id="form 3Example3" class="form-control form-control-lg"
                          placeholder="Worker Name" />
                        </div>
                      <!-- Email input -->
                    <div class="form-outline mb-4">
                    <label class="form-label" for="form3Example3">Email</label>
                    <input type="email" name="email" id="form3Example3" class="form-control form-control-lg"
                        placeholder="Email" required />
                    </div>
                      <!-- Password input -->
                      <div class="form-outline mb-4">
                      <label class="form-label" for="form3Example3">Password</label>
                        <input type="text" name="password" id="form3Example3" class="form-control form-control-lg"
                          placeholder="Password" />
                      </div>
                      <!-- City input -->
                      <div class="form-outline mb-4">
                      <label class="form-label" for="form3Example3">City</label>
                        <input type="text" name="city" id="form3Example3" class="form-control form-control-lg"
                          placeholder="City" />
                      </div>
                      <!-- Phone input -->
                        <div class="form-outline mb-4">
                        <label class="form-label" for="form3Example3">Phone number</label>
                        <input type="text" name="phone" id="form3Example3" class="form-control form-control-lg"
                            placeholder="Phone Number" pattern="[0-9]+" required />
                        </div>
                      <!-- Insert button -->
                      <div style="display: inline-block; margin-right: 10px;">
                        <button type="submit" class="btn btn-primary btn-lg" style="width: 100px;" name="insert">Insert</button>
                      </div>
                    </form>
            <!-- Insert Worker End -->
            <br>
    <div class="d-inline-block">
      <!-- Worker's list button -->
      <form action="insertProduct.php" method="post">
            <button type="submit" class="btn btn-primary btn-lg" style="width: 150px;">Product's List</button>
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

<?php

$filepath = __DIR__;
require_once($filepath . '/../classes/customer.php');
require_once($filepath . '/../classes/admin.php');
require_once($filepath . '/../classes/worker.php');
require_once($filepath . '/db.php');

// From review_order.php.php file - to save review
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['review'])) {
        $data = new db();
        // Get the item names, reviews, and item IDs from the submitted form
        $itemNames = $_POST['item_name'];
        $reviews = $_POST['review_text'];
        $itemID = $_POST['item_id'];
        $id_o = $_GET['id_o'];
        echo '<script>alert("id_o - '.$id_o.'");</script>';

        // Output item names, reviews, and item IDs using print_r() inside the loop
        foreach ($itemNames as $index => $itemName) {
            $reviewText = $reviews[$index];
            $itemIDValue = $itemID[$index];

            // Check if review text is empty
            if (empty($reviewText)) {
                echo '<script>alert("Please write a review for ' . $itemName . '");</script>';
            } else {
                echo '<script>alert("Item ID: ' . $itemIDValue . '\nItem Name: ' . $itemName . '\nReview: ' . $reviewText . '");</script>';

                if($data->save_review('review', $itemIDValue, $reviewText)){
                    echo '<script>alert("Your review has been saved");</script>';
                    $data->review_done($id_o);
                    echo '<script>window.location.href = "order.php";</script>';
                }
            }
        }
    }
}


?>
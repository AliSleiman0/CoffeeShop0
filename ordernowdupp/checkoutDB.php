<?php
// Start session
session_start();



// Include database connection file
require '../users\db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve the JSON string from the hidden input field
    $jsonData = $_POST['jsonData'] ?? '';

    // Decode the JSON string into a PHP array
    $data = json_decode($jsonData, true);

    // Check if decoding was successful
    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo "Error decoding JSON data: " . json_last_error_msg() . "\n";
    } else {
        // Iterate over each element of the array
        foreach ($data as $item) {
            // Access the productid and quantity
            $productid = $item['product_id'];
            $quantity = $item['quantity'];

            // Debugging: output the received data
            echo "productid: " . $productid . "\n";
            echo "quantity: " . $quantity . "\n";
        }

        // Assuming connection is established in users/db.php
       

        // Sample order details
        $customer_id = $_SESSION['user_id'];
        $order_date = date('Y-m-d H:i:s');
        $address = $_POST['customerAddress'];

        // Fetch all menu items (id, title, image, price)
        $query = "SELECT ItemID, Title, Image, Price FROM menuitems";
        $result = mysqli_query($con, $query);

        if (!$result) {
            die("Query failed: " . mysqli_error($con));
        }

        $menu_items = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $menu_items[$row['ItemID']] = $row;
        }

        // Calculate total amount
        $total_amount = 0;
        foreach ($data as $item) {
            $productid = $item['product_id'];
            $quantity = $item['quantity'];
            $total_amount += $menu_items[$productid]['Price'] * $quantity;
        }

        // Insert into orders table
        $query = "INSERT INTO `orders` (customer_id, order_date, total_amount, address) VALUES ($customer_id, '$order_date', $total_amount, '$address')";
        if (!mysqli_query($con, $query)) {
            die("Order insertion failed: " . mysqli_error($conn));
        }

        // Get the last inserted order ID
        $order_id = mysqli_insert_id($con);

        // Insert into order_items table
        foreach ($data as $item) {
            $productid = $item['product_id'];
            $quantity = $item['quantity'];
            $price = $menu_items[$productid]['Price'];

            $query = "INSERT INTO order_items (order_id, item_id, quantity, price) VALUES ($order_id, $productid, $quantity, $price)";
            if (!mysqli_query($con, $query)) {
                die("Order item insertion failed: " . mysqli_error($con));
            }
        }
         
         echo '<script type="text/javascript">';
         echo 'alert("Order Inserted Successfully!");';
         echo 'window.location.href = "../index.php";';
         echo '</script>';
         // Make sure to exit the script to prevent further execution
         exit();
       
       
    }
} else {
    echo '<script type="text/javascript">';
    echo 'alert("Order Insertion Failed!");';
    echo 'window.location.href = "index.php";';
    echo '</script>';
    // Make sure to exit the script to prevent further execution
    exit();
}

?>
<?php
require('../users/db.php');

// Check if orderID parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform order items deletion first
    $deleteItemsSql = "DELETE FROM order_items WHERE order_id = ?";
    if ($deleteItemsStmt = mysqli_prepare($con, $deleteItemsSql)) {
        // Bind order_id parameter
        mysqli_stmt_bind_param($deleteItemsStmt, "i", $_POST['orderID']);
        // Execute the deletion
        if (!mysqli_stmt_execute($deleteItemsStmt)) {
            // Error handling
            echo "<script>alert('Error deleting order items: " . mysqli_error($con) . "');</script>";
        }
        mysqli_stmt_close($deleteItemsStmt);
    } else {
        // Error handling for prepare statement
        echo "<script>alert('Prepare statement error: " . mysqli_error($con) . "');</script>";
    }

    // Proceed with deleting the order
    $deleteOrderSql = "DELETE FROM `orders` WHERE order_id = ?";
    if ($deleteOrderStmt = mysqli_prepare($con, $deleteOrderSql)) {
        // Bind order_id parameter
        mysqli_stmt_bind_param($deleteOrderStmt, "i", $_POST['orderID']);
        // Execute the deletion
        if (mysqli_stmt_execute($deleteOrderStmt)) {
            // Order deleted successfully
            echo '<script type="text/javascript">';
            echo 'alert("Order deleted Successfully!");';
            echo 'window.location.href = "admin.php";';
            echo '</script>';
         // Make sure to exit the script to prevent further execution
         exit();
        } else {
            // Error handling
            echo "<script>alert('Order deletion failed: " . mysqli_error($con) . "');</script>";
        }
        mysqli_stmt_close($deleteOrderStmt);
    } else {
        // Error handling for prepare statement
        echo "<script>alert('Prepare statement error: " . mysqli_error($con) . "');</script>";
    }

    // Close connection
    mysqli_close($con);
}
?>

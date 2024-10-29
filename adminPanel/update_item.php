<?php
require('../users/db.php');

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform item update
    $sql = "UPDATE menuitems SET `Title` = ?, `Image` = ?, `Price` = ? WHERE ItemID = ?";
    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ssdi", $productName, $productImage, $productPrice, $productID);

        // Set parameters
        $productID = $_POST['productID'];
        $productName = $_POST['productName'];
        $productImage = $_POST['productImage'];
        $productPrice = $_POST['productPrice'];

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Item updated successfully
            echo "<script>alert('Item Updated successfully.')</script>";
            header("Location: admin.php");
        } else {
            // Error handling
            echo "<script>alert('Item Update Failed: " . mysqli_error($con) . "')</script>";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        // Error handling for prepare statement
        echo "<script>alert('Prepare statement error: " . mysqli_error($con) . "')</script>";
    }

    // Close connection
    mysqli_close($con);
}
?>
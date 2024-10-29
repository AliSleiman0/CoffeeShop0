<?php
require('../users\db.php');

// Check if itemID parameter is set
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Perform item deletion
    $sql = "DELETE FROM menuitems WHERE ItemID  = ?";

    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "i",  $productID);

        // Set parameters
        $productID = $_POST['productID'];
       
      
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Item deleted successfully
         
            echo "<script>alert('Item Deleted successfully.')</script>";
            header("Location: admin.php");
        } else {
            // Error handling
            echo "<script>alert('Item Deletion Failed: " . mysqli_error($con) . "')</script>";
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

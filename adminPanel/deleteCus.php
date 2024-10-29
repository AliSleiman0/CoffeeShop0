<?php
// Check if the form is submitted
require('../users/db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    // Get customer ID from the form
    $customerID = $_POST["customerID"];
    
    // Prepare SQL statement to delete data from the database
    $sql = "DELETE FROM logins WHERE id=?";
    
    // Prepare and bind parameters to the SQL statement
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "i", $customerID);
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Record deleted successfully
            echo "<script>alert('Customer Deleted Successfully.')</script>";
            header("Location: admin.php");
        } else {
            echo "Error: " . mysqli_error($con);
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($con);
    }
    
    // Close connection
    mysqli_close($con);
} else {
    // Redirect back to the previous page if accessed directly
    header("Location: previous_page.php"); // Adjust the path to your previous page
    exit();
}
?>

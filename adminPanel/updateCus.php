<?php
require('../users/db.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Get form data
    $customerID = $_POST["customerID"];
    $customerName = $_POST["customerName"];
    $customerEmail = $_POST["customerEmail"];
    $customerPhoneNumber = $_POST["customerPhoneNumber"];
    
    // Prepare SQL statement to update data in the database  
    $sql = "UPDATE logins SET `name`=?, `number`=?,  `email`=? WHERE id=?";
    
    // Prepare and bind parameters to the SQL statement
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $customerName, $customerEmail, $customerPhoneNumber, $customerID);
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Record updated successfully
            echo "<script>alert('Customer Updated Successfully.')</script>";
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
  
    exit();
}
?>

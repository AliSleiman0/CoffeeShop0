<?php
require('../users\db.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include database connection file
  
    
    // Get form data
    $customerName = $_POST["customerName"];
    $customerNumber = $_POST["customerNumber"];
    $customerEmail = $_POST["customerEmail"];
    $customerPassword = $_POST["customerPassword"];
    
    // Prepare SQL statement to insert data into the database
    $sql = "INSERT INTO logins (`name`, `number`, `email`, `password`) VALUES (?, ?, ?, ?)";
    
    // Prepare and bind parameters to the SQL statement
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "ssss", $customerName, $customerNumber, $customerEmail, $customerPassword);
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Record inserted successfully
            echo "<script>alert('New Customer successfully.')</script>";
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

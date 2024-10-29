<?php
// Include the database connection file
require('../users\db.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Escape user inputs for security
    $itemName = mysqli_real_escape_string($con, $_POST['itemName']);
    $imageFileLink = mysqli_real_escape_string($con, $_POST['imageFileLink']);
    $itemPrice = mysqli_real_escape_string($con, $_POST['itemPrice']);

    // Prepare an insert statement with auto-increment primary key
    $sql = "INSERT INTO menuitems (Title, Image, Price) VALUES (?, ?, ?)";

    if ($stmt = mysqli_prepare($con, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "sss", $param_itemName, $param_imageFileLink, $param_itemPrice);

        // Set parameters
        $param_itemName = $itemName;
        $param_imageFileLink = $imageFileLink;
        $param_itemPrice = $itemPrice;

        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Item added successfully ?>
            <script> alert( "Item added successfully.") </script>
          <?php   header("Location: admin.php");
        } else {?>
            // Error handling
            <script> alert( "Item addition Failed.") </script>
            <?php 
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Close connection
    mysqli_close($con);
}
?>

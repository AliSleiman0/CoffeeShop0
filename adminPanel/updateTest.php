<?php
require('../users/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $testimonialID = $_POST['testimonialID'];
    $testimonialContent = $_POST['testimonialContent'];
    $testimonialImage = $_POST['testimonialImage'];
    $testimonialAuthor = $_POST['testimonialAuthor'];

    // Prepare and execute the SQL statement to update the testimonial in the database
    $sql = "UPDATE testimonials SET content=?, user_image=?, user_name=? WHERE id=?";
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssi", $testimonialContent, $testimonialImage, $testimonialAuthor, $testimonialID);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: admin.php");

        } else {
            echo "Error: " . mysqli_error($con);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo "Error: " . mysqli_error($con);
    }

    mysqli_close($con);
}
?>

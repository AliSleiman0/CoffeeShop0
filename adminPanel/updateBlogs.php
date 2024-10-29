<?php
require('../users/db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect data from the form
    $id = $_POST['blogID'];
    $title = $_POST['blogTitle'];
    $author = $_POST['blogAuthor'];
    $image = $_POST['blogImage'];
    $link = $_POST['blogLink'];
    $description = $_POST['blogDescription'];
 
    // Prepare and execute the SQL statement to update the blog in the database
    $sql = "UPDATE blogs SET title=?, author=?, image=?, link=?, description=? WHERE id=?";
    if ($stmt = mysqli_prepare($con, $sql)) {
        mysqli_stmt_bind_param($stmt, "sssssi", $title, $author, $image, $link, $description, $id);
        if (mysqli_stmt_execute($stmt)) {
            header("Location: admin.php");
            echo "<script>alert('Blog Updated Successfully.')</script>";
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

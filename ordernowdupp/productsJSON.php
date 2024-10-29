<?php
// products.php
require '../users/db.php';

// Check if the request is an AJAX request
$isAjaxRequest = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] === 'XMLHttpRequest';

// Fetch products from the database
$sql = "SELECT ItemID, Title, Image, Price FROM menuitems";
$result = $con->query($sql);
$products = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $products[] = array(
            'id' => $row['ItemID'],
            'title' => $row['Title'],
            'image' => $row['Image'],
            'price' => $row['Price']
        );
    }
} else {
    $products = array('message' => 'No products available.');
}

// Output JSON data for AJAX requests

   
    echo json_encode($products);

$con->close();
?>
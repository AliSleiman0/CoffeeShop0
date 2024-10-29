<?php
// products.php
require '../users\db.php';

// Fetch products from the database
$sql = "SELECT ItemID, Title, Image, Price FROM menuitems";
$result = $con->query($sql);

$products = array();

if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
   
        echo '<div class="item" data-id="' . htmlspecialchars($row['ItemID']) . '">';
        echo '<img src="../' . htmlspecialchars($row['Image']) .'" alt="">';
        echo '<h2>' . htmlspecialchars($row['Title']) . '</h2>';
        echo '<div class="price">$' . htmlspecialchars($row['Price']) . '</div>';
        echo '<button data-id="' . htmlspecialchars($row['ItemID']) . '" class="addCart" >Add To Cart</button>';
        echo '</div>';

        $products[] = array(
            'id' => $row['ItemID'],
            'title' => $row['Title'],
            'image' => $row['Image'],
            'price' => $row['Price']
        );
    
    }
} else {
    echo '<p>No products available.</p>';
}

$con->close();
?>

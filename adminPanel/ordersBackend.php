<?php
// Assuming connection is established in users/db.php
require('../users\db.php');;

// Fetch orders from the database
$orderQuery = "SELECT `orders`.order_id, `orders`.customer_id, `orders`.order_date, `orders`.total_amount, `orders`.address, logins.name as customer_name
               FROM `orders`
               JOIN `logins` ON `orders`.customer_id = logins.id"; // Assuming you have a customers table
$orderResult = mysqli_query($con, $orderQuery);

if (!$orderResult) {
    die("Query failed: " . mysqli_error($con));
}
?>

<h2 id="orders">Orders</h2>

<table class="table table-striped table-hover">
    <thead>
        <tr>
            <th>Order ID</th>
            <th>Customer Name</th>
            <th>Order Date</th>
            <th>Total Amount</th>
            <th>Address</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        // Loop through orders and display them
        if ($orderResult->num_rows > 0) {
            foreach ($orderResult as $order) {
                echo '<tr>
                    <td>' . htmlspecialchars($order["order_id"]) . '</td>
                    <td>' . htmlspecialchars($order["customer_name"]) . '</td>
                    <td>' . htmlspecialchars($order["order_date"]) . '</td>
                    <td>$' . htmlspecialchars($order["total_amount"]) . '</td>
                    <td>' . htmlspecialchars($order["address"]) . '</td>
                    <td>
                        <button class="btn btn-sm btn-primary" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#editOrderModal" title="Edit" onclick="orderEditForm(this)"><i class="fas fa-edit"></i></button>
                        <button class="btn btn-sm btn-danger" data-toggle="tooltip" data-bs-toggle="modal" data-bs-target="#deleteOrderModal" title="Delete" onclick="setOrderID(this)"><i class="fas fa-trash-alt"></i></button>
                    </td>
                </tr>';
            }
        } else {
            echo '<tr><td colspan="6">No orders found</td></tr>';
        }
        ?>
    </tbody>
</table>

<!-- Modal for editing an order -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal content will be loaded dynamically using JavaScript -->
        </div>
    </div>
</div>

<!-- Modal for deleting an order -->
<div class="modal fade" id="deleteOrderModal" tabindex="-1" aria-labelledby="deleteOrderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <!-- Modal content will be loaded dynamically using JavaScript -->
        </div>
    </div>
</div>

<script>
// JavaScript functions for handling modal forms
function orderEditForm(button) {
    // Get order details and populate the edit form
    var orderId = button.closest('tr').children[0].innerText;
    // Implement AJAX call to fetch order details and populate the modal
}

function setOrderID(button) {
    // Get order ID and set it in the delete confirmation form
    var orderId = button.closest('tr').children[0].innerText;
    // Implement setting order ID in the modal
}
</script>

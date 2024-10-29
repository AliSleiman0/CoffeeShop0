<?php
    session_start();
    require '../users\db.php';
    $sql = "SELECT customer_id, order_date, total_amount,address FROM orders WHERE order_id = ?";
    $stmt = $con->prepare($sql);
   
    $stmt->bind_param("i", $_SESSION['order_id']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $order = $result->fetch_assoc();
        var_dump($order);
    } else {
        die("Order not found.");
    }
    $stmt->close();

$con->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Order Confirmation</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h1 class="h4 mb-0">Order Confirmation</h1>
            </div>
            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Order ID:</div>
                    <div class="col-sm-8"><?php echo htmlspecialchars($_SESSION['order_id'], ENT_QUOTES); ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Customer ID:</div>
                    <div class="col-sm-8"><?php echo htmlspecialchars($order['customer_id'], ENT_QUOTES); ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Order Date:</div>
                    <div class="col-sm-8"><?php echo htmlspecialchars($order['order_date'], ENT_QUOTES); ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Total Amount:</div>
                    <div class="col-sm-8">$<?php echo htmlspecialchars($order['total_amount'], ENT_QUOTES); ?></div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 font-weight-bold">Address:</div>
                    <div class="col-sm-8"><?php echo htmlspecialchars($order['address'], ENT_QUOTES); ?></div>
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="index.php" class="btn btn-primary">Return to Home</a>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

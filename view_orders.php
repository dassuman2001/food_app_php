<?php
// view_orders.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
include('db.php');

$sql = "SELECT orders.*, users.username FROM orders JOIN users ON orders.user_id = users.id";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Orders</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Internal CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .order-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .order-container h2 {
            margin-top: 0;
        }

        .order-container a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .order-container a:hover {
            text-decoration: underline;
        }

        .back-to-dashboard {
            display: block;
            margin-top: 20px;
            text-align: center;
        }
    </style>
</head>
<body>
    <h1 class="text-center">All Orders</h1>
    <?php while ($order = mysqli_fetch_assoc($result)) { ?>
        <div class="order-container">
            <h2>Order ID: <?php echo $order['id']; ?></h2>
            <p><strong>Username:</strong> <?php echo $order['username']; ?></p>
            <p><strong>Total Price:</strong> $<?php echo $order['total_price']; ?></p>
            <p><strong>Status:</strong> <?php echo $order['status']; ?></p>
            <p><strong>Ordered at:</strong> <?php echo $order['created_at']; ?></p>
            <a href="update_order.php?order_id=<?php echo $order['id']; ?>&status=Completed">Mark as Completed</a>
        </div>
    <?php } ?>
    <a class="back-to-dashboard" href="admin_dashboard.php">Back to Dashboard</a>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

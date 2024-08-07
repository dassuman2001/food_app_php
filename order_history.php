<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Internal CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            margin-top: 20px;
        }

        h1 {
            margin-bottom: 20px;
        }

        .order-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fff;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Order History</h1>
        <?php
        session_start();
        include('db.php');

        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit;
        }

        $user_id = $_SESSION['user_id'];
        $sql = "SELECT * FROM orders WHERE user_id = '$user_id'";
        $result = mysqli_query($conn, $sql);

        while ($order = mysqli_fetch_assoc($result)) { ?>
            <div class="order-item">
                <h2>Order ID: <?php echo $order['id']; ?></h2>
                <p>Total Price: $<?php echo $order['total_price']; ?></p>
                <p>Status: <?php echo $order['status']; ?></p>
                <p>Ordered at: <?php echo $order['created_at']; ?></p>
            </div>
        <?php } ?>

        <a href="index.php" class="back-link">Back to Restaurants</a>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

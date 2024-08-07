<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
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

        .cart-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fff;
        }

        .btn-primary {
            background-color: #f36f6f;
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #d9534f;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Cart</h1>
        <?php
        session_start();

        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit;
        }

        if (isset($_GET['action']) && $_GET['action'] == 'delete') {
            $item_index = $_GET['index'];
            unset($_SESSION['cart'][$item_index]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index the array
            header("Location: view_cart.php");
            exit;
        }
        ?>

        <?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
            <form method="post" action="place_order.php">
                <?php foreach ($_SESSION['cart'] as $index => $item) { ?>
                    <div class="cart-item">
                        <h2><?php echo $item['name']; ?></h2>
                        <p>Price: $<?php echo $item['price']; ?></p>
                        <a href="view_cart.php?action=delete&index=<?php echo $index; ?>" class="btn btn-danger">Remove</a>
                        <input type="hidden" name="restaurant_id" value="<?php echo $item['restaurant_id']; ?>">
                    </div>
                <?php } ?>
                <input type="submit" class="btn btn-primary" value="Place Order">
            </form>
        <?php } else { ?>
            <p>Your cart is empty.</p>
        <?php } ?>

        <a href="index.php" class="back-link">Back to Restaurants</a>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

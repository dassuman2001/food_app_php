<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dishes</title>
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

        .dish-item {
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 15px;
            margin-bottom: 15px;
            background-color: #fff;
        }

        .dish-item h2 {
            margin-top: 0;
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
        <h1>Dishes</h1>
        <?php
        session_start();
        include('db.php');

        $restaurant_id = $_GET['restaurant_id'];
        $sql = "SELECT * FROM dishes WHERE restaurant_id = '$restaurant_id'";
        $result = mysqli_query($conn, $sql);

        while ($dish = mysqli_fetch_assoc($result)) { ?>
            <div class="dish-item">
                <h2><?php echo $dish['name']; ?></h2>
                <p><?php echo $dish['description']; ?></p>
                <p>Price: $<?php echo $dish['price']; ?></p>
                <a href="add_to_cart.php?dish_id=<?php echo $dish['id']; ?>&restaurant_id=<?php echo $restaurant_id; ?>" class="btn btn-primary">Add to Cart</a>
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

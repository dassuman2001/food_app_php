<?php
// admin_restaurants.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}
include('db.php');

$sql = "SELECT * FROM restaurants";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Restaurants</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Internal CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            padding: 20px;
        }

        .restaurant-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .restaurant-container h2 {
            margin-top: 0;
        }

        .restaurant-container a {
            margin-right: 10px;
            color: #007bff;
            text-decoration: none;
        }

        .restaurant-container a:hover {
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
    <h1>Manage Restaurants</h1>
    <?php while ($restaurant = mysqli_fetch_assoc($result)) { ?>
        <div class="restaurant-container">
            <h2><?php echo $restaurant['name']; ?></h2>
            <p><?php echo $restaurant['address']; ?></p>
            <p><?php echo $restaurant['phone']; ?></p>
            <a href="update_restaurant.php?id=<?php echo $restaurant['id']; ?>">Update</a>
            <a href="delete_restaurant.php?id=<?php echo $restaurant['id']; ?>">Delete</a>
        </div>
    <?php } ?>
    <a class="back-to-dashboard" href="admin_dashboard.php">Back to Dashboard</a>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>

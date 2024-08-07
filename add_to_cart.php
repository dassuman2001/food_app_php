<?php
// add_to_cart.php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('db.php');

$dish_id = $_GET['dish_id'];
$restaurant_id = $_GET['restaurant_id'];

$sql = "SELECT * FROM dishes WHERE id = '$dish_id'";
$result = mysqli_query($conn, $sql);
$dish = mysqli_fetch_assoc($result);

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$_SESSION['cart'][] = [
    'id' => $dish['id'],
    'name' => $dish['name'],
    'price' => $dish['price'],
    'restaurant_id' => $restaurant_id
];

header("Location: view_cart.php");
?>

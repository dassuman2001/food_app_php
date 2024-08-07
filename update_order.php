<?php
// update_order.php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include('db.php');

$order_id = $_GET['order_id'];
$status = $_GET['status'];

$sql = "UPDATE orders SET status = '$status' WHERE id = '$order_id'";
if (mysqli_query($conn, $sql)) {
    header("Location: view_orders.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>

<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: admin_login.php");
    exit;
}

include('db.php');

$id = $_GET['id'];
$id = mysqli_real_escape_string($conn, $id); // Sanitize input

// Delete the restaurant
$sql = "DELETE FROM restaurants WHERE id = '$id'";
if (mysqli_query($conn, $sql)) {
    header("Location: admin_restaurants.php");
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
?>

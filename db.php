<?php
// db.php
$servername = "localhost";
$username = "root"; // default username for XAMPP/WAMP
$password = "Password@2001"; // default password for XAMPP/WAMP
$dbname = "food_delivery_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

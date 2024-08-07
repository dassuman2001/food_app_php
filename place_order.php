<?php
// place_order.php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

include('db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $restaurant_id = $_POST['restaurant_id'];
    $total_price = 0;

    // Calculate the total price
    foreach ($_SESSION['cart'] as $item) {
        $total_price += $item['price'];
    }

    // Insert into orders table
    $sql = "INSERT INTO orders (user_id, restaurant_id, total_price) VALUES ('$user_id', '$restaurant_id', '$total_price')";
    if (mysqli_query($conn, $sql)) {
        $order_id = mysqli_insert_id($conn);

        // Insert into order_details table
        foreach ($_SESSION['cart'] as $item) {
            $dish_id = $item['id'];
            $price = $item['price'];
            $quantity = 1; // For simplicity, we assume quantity is always 1

            $sql = "INSERT INTO order_details (order_id, dish_id, quantity, price) VALUES ('$order_id', '$dish_id', '$quantity', '$price')";
            mysqli_query($conn, $sql);
        }

        // Clear the cart
        $_SESSION['cart'] = [];
        header("Location: order_history.php");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<h1>Place Order</h1>
<?php if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) { ?>
    <form method="post" action="place_order.php">
        <input type="hidden" name="restaurant_id" value="<?php echo $_SESSION['cart'][0]['restaurant_id']; ?>">
        <?php foreach ($_SESSION['cart'] as $item) { ?>
            <div>
                <h2><?php echo $item['name']; ?></h2>
                <p>Price: $<?php echo $item['price']; ?></p>
            </div>
        <?php } ?>
        <input type="submit" value="Confirm Order">
    </form>
<?php } else { ?>
    <p>Your cart is empty.</p>
<?php } ?>

<a href="index.php">Back to Restaurants</a>

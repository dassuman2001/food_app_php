<?php
// Start the session
session_start();

// Include database connection
include('db.php');

// Initialize variables
$username = $password = $email = "";
$error_message = "";

// Check if form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);  // Store password as plain string
    $email = trim($_POST['email']);

    // Validate input
    if (empty($username) || empty($password) || empty($email)) {
        $error_message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Invalid email format.";
    } else {
        // Check if email is already registered
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        if ($stmt) {
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                $error_message = "Email is already registered.";
            } else {
                // Prepare an SQL statement to prevent SQL injection
                $stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");
                if ($stmt) {
                    $stmt->bind_param("sss", $username, $password, $email);

                    // Execute the prepared statement
                    if ($stmt->execute()) {
                        header("Location: login.php");
                        exit;
                    } else {
                        $error_message = "Error: " . $stmt->error;
                    }

                    // Close the statement
                    $stmt->close();
                } else {
                    $error_message = "Error preparing statement: " . $conn->error;
                }
            }

            // Close the statement
            $stmt->close();
        } else {
            $error_message = "Error preparing statement: " . $conn->error;
        }
    }
}

// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Internal CSS -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .register-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
        }

        h1 {
            margin-bottom: 20px;
            text-align: center;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .btn-primary {
            background-color: #f36f6f;
            border: none;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #d9534f;
        }

        .error-message {
            color: red;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1>Register</h1>
        <form id="registerForm" method="post" action="register.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" class="form-control" id="username" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <button type="submit" class="btn btn-primary btn-block">Register</button>
        </form>
        <p id="formError" class="error-message"><?php echo htmlspecialchars($error_message); ?></p>
    </div>
    <!-- Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!-- Internal JS -->
    <script>
        document.getElementById('registerForm').addEventListener('submit', function(event) {
            var username = document.getElementById('username').value.trim();
            var password = document.getElementById('password').value.trim();
            var email = document.getElementById('email').value.trim();
            var errorMessage = "";

            if (username === "" || password === "" || email === "") {
                errorMessage = "All fields are required.";
            } else if (!validateEmail(email)) {
                errorMessage = "Invalid email format.";
            }

            if (errorMessage) {
                event.preventDefault();
                document.getElementById('formError').textContent = errorMessage;
            }
        });

        function validateEmail(email) {
            var re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return re.test(email);
        }
    </script>
</body>
</html>

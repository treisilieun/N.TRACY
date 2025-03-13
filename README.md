<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce for Small Businesses</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Welcome to Small Biz E-Commerce</h1>
    <a href="register.php">Register</a> | <a href="login.php">Login</a>
    <div id="products"><?php include 'index.php'; ?></div>
   
</body>
</html>

<style>
body {
    font-family: Arial, sans-serif;
    text-align: center;
    background-color: purple;
    padding: 0;
}
.product {
    border: 1px solid red;
    padding: 10px;
    margin: 10px;
    display: inline-bloon;;
}
</style>

<script>
public class PaymentProcessing {
    public static boolean processPayment(String cardNumber, double amount) {
        if (cardNumber.length() == 16 && amount > 0) {
            System.out.println("Payment of $" + amount + " processed successfully.");
            return true;
        }
        System.out.println("Payment failed.");
        return false;
    }

    public static void main(String[] args) {
        processPayment("1234567812345678", 100.00);
    }
}
</script>

<style>
<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    die("Login required.");
}

$product _id = $_GET['id'];
$user_id = $_SESSION['user_id'];

$sql = "INSERT INTO orders (user_id, total_amount) VALUES ('$user_id', (SELECT price FROM products WHERE id='$product_id'))";
if (mysqli_query($conn, $sql)) {
    echo "Order placed successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}
?>


<?php
include 'config.php';
$result = mysqli_query($conn, "SELECT * FROM products");

while ($row = mysqli_fetch_assoc($result)) {
    echo "<div class='product'>";
    echo "<h2>{$row['name']}</h2>";
    echo "<p>{$row['description']}</p>";
    echo "<p>Price: $ {$row['price']}</p>";
    echo "<a href='checkout.php?id={$row['id']}'>Buy Now</a>";
    echo "</div>";
}
?>

<?php
session_start();
include 'config.php';

if ($_SESSION['role'] !== 'seller') {
    die("Unauthorized access.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $desc = $_POST['description'];
    $price = $_POST['price'];
    $seller_id = $_SESSION['user_id'];

    $sql = "INSERT INTO products (seller_id, name, description, price) VALUES ('$seller_id', '$name', '$desc', '$price')";
    if (mysqli_query($conn, $sql)) {
        echo "Product added successfully!";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

 <?php
session_start();
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
    } else {
        echo "Invalid credentials.";
    }
}
?>

<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = $_POST['role'];

    $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', '$role')";
    if (mysqli_query($conn, $sql)) {
        echo "Registration successful! <a href='login.php'>Login here</a>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>
</style>

<style>
CREATE DATABASE ecommerce_db;
USE ecommerce_db;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('seller', 'buyer') NOT NULL
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10,2),
    image VARCHAR(255),
    FOREIGN KEY (seller_id) REFERENCES users(id)
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT,
    total_amount DECIMAL(10,2),
    status ENUM('pending', 'completed') DEFAULT 'pending',
    FOREIGN KEY (user_id) REFERENCES users(id)
);
</style>

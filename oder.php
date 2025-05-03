<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $product_name = $_POST['product_name'];
    $quantity = $_POST['quantity'];

    $stmt = $conn->prepare("INSERT INTO orders (user_id, product_name, quantity) VALUES (?, ?, ?)");
    $stmt->bind_param("isi", $user_id, $product_name, $quantity);

    if ($stmt->execute()) {
        $success = "Order placed successfully!";
    } else {
        $error = "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Place Order</title>
</head>
<body style="margin:0; padding:0; font-family:Arial, sans-serif; background:linear-gradient(to right, #6dd5ed, #2193b0); height:100vh; display:flex; justify-content:center; align-items:center;">

<div style="background:#fff; padding:40px; border-radius:10px; box-shadow:0 5px 15px rgba(0,0,0,0.2); width:100%; max-width:400px;">
    <h2 style="text-align:center; color:#333; margin-bottom:20px;">Place an Order</h2>

    <?php if (isset($success)): ?>
        <div style="background-color:#d4edda; color:#155724; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;">
            <?php echo $success; ?>
        </div>
    <?php elseif (isset($error)): ?>
        <div style="background-color:#f8d7da; color:#721c24; padding:10px; border-radius:5px; margin-bottom:15px; text-align:center;">
            <?php echo $error; ?>
        </div>
    <?php endif; ?>

    <form method="POST" style="display:flex; flex-direction:column;">
        <label for="product_name" style="margin-bottom:5px; font-weight:bold;">Product Name:</label>
        <input type="text" name="product_name" id="product_name" required placeholder="e.g. Apple iPhone"
               style="padding:12px; margin-bottom:15px; border:1px solid #ccc; border-radius:5px; font-size:16px;">

        <label for="quantity" style="margin-bottom:5px; font-weight:bold;">Quantity:</label>
        <input type="number" name="quantity" id="quantity" required min="1" placeholder="e.g. 2"
               style="padding:12px; margin-bottom:20px; border:1px solid #ccc; border-radius:5px; font-size:16px;">

        <button type="submit"
                style="padding:12px; background-color:#2193b0; color:white; font-size:16px; border:none; border-radius:5px; cursor:pointer;">
            Place Order
        </button>
    </form>
</div>

</body>
</html>

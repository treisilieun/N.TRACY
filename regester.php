<?php
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $name = $_POST['name'];
    $address = $_POST['address'];

    $sql = "INSERT INTO users (email, password, name, address) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $email, $password, $name, $address);

    if ($stmt->execute()) {
        $success = "Registration successful!";
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
    <title>Register</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; background: linear-gradient(to right, #00c6ff, #0072ff); height: 100vh; display: flex; justify-content: center; align-items: center;">

    <div style="background-color: #ffffff; padding: 40px; border-radius: 10px; width: 100%; max-width: 400px; box-shadow: 0 5px 15px rgba(0,0,0,0.2);">
        <h2 style="text-align: center; margin-bottom: 20px; color: #333;">Register</h2>

        <?php if (isset($success)): ?>
            <div style="background-color: #d4edda; color: #155724; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php echo $success; ?>
            </div>
        <?php elseif (isset($error)): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form method="POST" style="display: flex; flex-direction: column;">
            <input type="email" name="email" required placeholder="Email" 
                style="padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            <input type="password" name="password" required placeholder="Password" 
                style="padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            <input type="text" name="name" required placeholder="Full Name" 
                style="padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">
            <textarea name="address" required placeholder="Shipping Address"
                style="padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px; resize: vertical;"></textarea>
            
            <button type="submit"
                style="padding: 12px; background-color: #0072ff; color: white; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
                Register
            </button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            Already have an account? 
            <a href="login.php" style="color: #0072ff; font-weight: bold; text-decoration: none;">Login here</a>
        </p>
    </div>

</body>
</html>



<?php
session_start();
include('db_connect.php');

if (isset($_SESSION['user_id'])) {
    header('Location: oder.php');  // Change to your actual destination
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];  // Form input: email
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($user_id, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            header('Location: oder.php');
            exit();
        } else {
            $error_message = "Incorrect password!";
        }
    } else {
        $error_message = "No user found with that email.";
    }

    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body style="margin:0; padding:0; font-family:Arial, sans-serif; background: linear-gradient(to right, #00c6ff, #0072ff); height:100vh; display:flex; justify-content:center; align-items:center;">

    <div style="background-color: #fff; padding: 40px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.1); width: 100%; max-width: 400px;">
        <h2 style="text-align: center; margin-bottom: 25px; color: #333;">Login</h2>

        <?php if (isset($error_message)): ?>
            <div style="background-color: #f8d7da; color: #721c24; padding: 10px; border-radius: 5px; margin-bottom: 15px; text-align: center;">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" style="display: flex; flex-direction: column;">
            <label for="email" style="margin-bottom: 5px; font-weight: bold;">Email:</label>
            <input type="email" name="email" id="email" required placeholder="Enter your email"
                style="padding: 12px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">

            <label for="password" style="margin-bottom: 5px; font-weight: bold;">Password:</label>
            <input type="password" name="password" id="password" required placeholder="Enter your password"
                style="padding: 12px; margin-bottom: 20px; border: 1px solid #ccc; border-radius: 5px; font-size: 16px;">

            <button type="submit"
                style="padding: 12px; background-color: #0072ff; color: white; font-size: 16px; border: none; border-radius: 5px; cursor: pointer;">
                Login
            </button>
        </form>

        <p style="text-align: center; margin-top: 15px;">
            Don't have an account?
            <a href="regester.php" style="color: #0072ff; font-weight: bold; text-decoration: none;">Register here</a>
        </p>
    </div>

</body>
</html>


<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
require_once 'db.php';

if (isset($_SESSION['user_id'])) {
    // If already logged in, redirect to dashboard
    header("Location: dashboard.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    // Query to check user by username or email
    $result = $conn->query("SELECT * FROM web_tbl WHERE username='$identifier' OR email='$identifier' LIMIT 1");
    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        // Use password_verify for hashed passwords
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['email']; // <-- gamitin ang email bilang session id
            header("Location: dashboard.php");
            exit();
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "User not found.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link href="Style.css" rel="stylesheet">
</head>
<body class="fade-in">
    <div class="container">
        <h2><span style="color:#fff; text-shadow:0 0 12px #0ff;">&#x1F3AE;</span> Login</h2>
        <form action="login.php" method="post" autocomplete="off">
            <label for="identifier"><b>Email or Username</b></label>
            <input type="text" placeholder="Email or Username" name="identifier" required> <br>

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <div class="button-group">
                <button type="submit">Login</button>
                <button type="button" class="forgotbtn" style="background:linear-gradient(90deg,#22223b,#0ff);color:#fff;">Forgot?</button>
            </div>
            <label style="display:flex;align-items:center;margin-top:10px;">
                <input type="checkbox" checked="checked" name="remember" style="margin-right:8px;"> Remember me
            </label>
        </form>
        <?php if (isset($error)): ?>
            <div style="color:#f44336; margin-top:10px; text-align:center;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endif; ?>
        <div class="footer" style="margin-top:18px;text-align:center;">
            <span class="reg">Don't have an account? <a href="signup.php">Register here</a></span>
        </div>
    </div>
</body>
</html>
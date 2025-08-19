<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = $_POST['identifier'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM web_tbl WHERE email = ?");
    $stmt->bind_param("s", $identifier);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($user = $result->fetch_assoc()) {
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['email'] = $user['email'];
            $_SESSION['password'] = $user['password'];
            header("Location: dashboard.php");
            exit;
        } else {
            echo '
            <div style="padding: 15px; background-color: #fff3cd; color: #856404; border: 1px solid #ffeeba; border-radius: 5px;">
                <strong>⚠ Warning:</strong> Incorrect password.<br>
                <a href="login.php">Try Again</a>
            </div>';
        }
    } else {
        echo '
        <div style="padding: 15px; background-color: #ffebee; color: #990000; border: 1px solid #f5c2c7; border-radius: 5px;">
            <strong>❌ Error:</strong> No account found.<br>
            <a href="login.php">Try Again</a>
        </div>';
    }
}
?>
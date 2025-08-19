<?php
$host = "localhost";
$users = "root";
$pass = "";
$db = "website";

$conn = new mysqli($host, $users, $pass, $db);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$full_name = $_POST['full_name'];
$username = $_POST['username'];
$email = $_POST['email'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT);
$role = $_POST['role'];

// Check if email already exists
$check = $conn->prepare("SELECT id FROM users WHERE email = ?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();
if ($check->num_rows > 0) {
    // Redirect back to add_user.php with error message
    header("Location: add_user.php?error=invalid_email");
    exit();
}
$check->close();

$sql = "INSERT INTO users (full_name, username, email, password, role)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $full_name, $username, $email, $password, $role);

if ($stmt->execute()) {
  header("Location: dashboard.php?success=1");
  exit();
} else {
  header("Location: add_user.php?error=unknown");
  exit();
}

$stmt->close();
$conn->close();
?>

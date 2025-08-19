<?php
require_once 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role_name = trim($_POST['role_name']);
    $role_description = trim($_POST['role_description']);

    if ($role_name !== '') {
        $stmt = $conn->prepare("INSERT INTO roles (role_name, role_description) VALUES (?, ?)");
        $stmt->bind_param("ss", $role_name, $role_description);
        $stmt->execute();
        $stmt->close();
    }
}
header("Location: Dashboard.php");
exit();
?>


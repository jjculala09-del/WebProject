<?php
$conn = new mysqli("localhost", "root", "", "website"); 

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $first_name = $_POST['Firstname'];
    $last_name = $_POST['Lastname'];
    $username = $_POST['Username'];
    $email = $_POST['Email'];
    $number = $_POST['Contact_Number'];
    $hashed = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check for duplicates (email or number)
    $check = $conn->prepare("SELECT * FROM web_tbl WHERE email = ? OR number = ?");
    $check->bind_param("ss", $email, $number);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        echo "<p style='color:red;'>Duplicate entry found. <a href='signup.php'>Try again</a></p>";
    } else {
        // Prepare SQL insert
        $stmt = $conn->prepare("INSERT INTO web_tbl (first_name, last_name, username, email, number, password) VALUES (?, ?, ?, ?, ?, ?)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("ssssss", $first_name, $last_name, $username, $email, $number, $hashed);
        if ($stmt->execute()) {
            echo "<p style='color:green;'>User registered successfully! <a href='login.php'>Sign in</a></p>";
        } else {
            echo "<p style='color:red;'>Insert failed: " . $stmt->error . " <a href='signup.php'>Try again</a></p>";
        }
        $stmt->close();
    }
    $check->close();
}
$conn->close();
?>
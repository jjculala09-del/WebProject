<?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Collect and sanitize input data
        $firstname = htmlspecialchars($_POST['Firstname']);
        $lastname = htmlspecialchars($_POST['Lastname']);
        $username = htmlspecialchars($_POST['Username']);
        $email = htmlspecialchars($_POST['Email']);
        $contact_number = htmlspecialchars($_POST['Contact_Number']);
        $password = $_POST['password']; // Keep password as plain text for hashing
        $confirm_password = $_POST['psw-confirm'];

        
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration Form</title>
    <meta charset="utf-8">
    <link href="Style.css" rel="stylesheet">
</head>
<body class="fade-in">
    <div class="container">
        <h2><span style="color:#fff; text-shadow:0 0 12px #0ff;">&#x1F3AE;</span> Register</h2>
        <form action="register_process.php" method="post" autocomplete="off">
            <label for="Firstname"><b>Firstname</b></label>
            <input type="text" placeholder="Enter First Name" name="Firstname" required>

            <label for="Lastname"><b>Lastname</b></label>
            <input type="text" placeholder="Enter Last Name" name="Lastname" required>

            <label for="Username"><b>Username</b></label>
            <input type="text" placeholder="Enter Username" name="Username" required>

            <label for="Email"><b>Email</b></label>
            <input type="email" placeholder="Enter Email" name="Email" required> <br>

            <label for="Contact_Number"><b>Number</b></label>
            <input type="text" placeholder="Cell phone Number" name="Contact_Number" required> 

            <label for="password"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" required>

            <label for="psw-confirm"><b>Confirm Password</b></label>
            <input type="password" placeholder="Confirm Password" name="psw-confirm" required>

            <div class="button-group">
                <button type="submit">Register</button>
                <button type="button" class="cancelbtn">Cancel</button>
            </div>
            <br>
        </form>
        <div class="footer" style="margin-top:18px;text-align:center;">
            <span class="psw">Already have an account? <a href="login.php">Login</a></span>
        </div>
    </div>
</body>
</html>
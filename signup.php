<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up</title>
<style>
    body {
        background-color: #000;
        color: #fff;
        font-family: Arial, sans-serif;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }
    .signup-container {
        background-color: #111;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px #fff;
        width: 300px;
    }
    input[type="text"], input[type="password"], input[type="email"] {
        width: 100%;
        padding: 10px;
        margin: 10px 0;
        border: 1px solid #fff;
        border-radius: 4px;
        background-color: #000;
        color: #fff;
    }
    input[type="submit"] {
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        border: none;
        border-radius: 4px;
        background-color: #fff;
        color: #000;
        font-weight: bold;
        cursor: pointer;
    }
    input[type="submit"]:hover {
        background-color: #ddd;
    }
    .login-btn {
        background-color: #444;
        color: #fff;
    }
    .login-btn:hover {
        background-color: #666;
    }
    .error, .success {
        margin-top: 10px;
        text-align: center;
    }
    .error { color: #ff4d4d; }
    .success { color: #4dff4d; }
</style>
</head>
<body>

<div class="signup-container">
    <h2>Sign Up</h2>

    <form action="signupLogic.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="password" name="confirm_password" placeholder="Confirm Password" required>
        <input type="submit" value="Sign Up">
    </form>

    <!-- Log In Button -->
    <form action="login.php" method="get">
        <input type="submit" class="login-btn" value="Log In">
    </form>

    <?php
    if(isset($_SESSION['signup_error'])){
        echo "<div class='error'>".$_SESSION['signup_error']."</div>";
        unset($_SESSION['signup_error']);
    }

    if(isset($_SESSION['signup_success'])){
        echo "<div class='success'>".$_SESSION['signup_success']."</div>";
        unset($_SESSION['signup_success']);
    }
    ?>
</div>

</body>
</html>

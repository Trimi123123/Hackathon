<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Log In</title>
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
    .login-container {
        background-color: #111;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 0 10px #fff;
        width: 300px;
    }
    input[type="text"], input[type="password"] {
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
    .signup-btn {
        background-color: #444;
        color: #fff;
    }
    .signup-btn:hover {
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

<div class="login-container">
    <h2>Log In</h2>

    <form action="loginLogic.php" method="POST">
        <input type="text" name="username_email" placeholder="Username or Email" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Log In">
    </form>

    <!-- Back to Sign Up -->
    <form action="signup.php" method="get">
        <input type="submit" class="signup-btn" value="Sign Up">
    </form>

    <?php
    if(isset($_SESSION['login_error'])){
        echo "<div class='error'>".$_SESSION['login_error']."</div>";
        unset($_SESSION['login_error']);
    }

    if(isset($_SESSION['login_success'])){
        echo "<div class='success'>".$_SESSION['login_success']."</div>";
        unset($_SESSION['login_success']);
    }
    ?>
</div>

</body>
</html>

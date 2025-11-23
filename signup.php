<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Sign Up - Quantum Arcade</title>
<style>
body {
    margin: 0;
    background-color: #1e1e1e;
    color: #e0e0e0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

header {
    background: linear-gradient(90deg, #3a3a3a, #2c2c2c);
    padding: 40px 20px;
    text-align: center;
    color: #fff;
    box-shadow: 0 4px 10px rgba(0,0,0,0.7);
    border-bottom: 2px solid #444;
}

header h1 {
    font-size: 3em;
    letter-spacing: 2px;
    margin: 0;
    text-shadow: 1px 1px 5px #000;
}

.container {
    max-width: 500px;
    margin: 60px auto;
    background-color: #2f2f2f;
    padding: 40px;
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0,0,0,0.7);
}

.container h2 {
    text-align: center;
    margin-bottom: 25px;
    border-bottom: 2px solid #444;
    padding-bottom: 10px;
    font-size: 2em;
}

input {
    width: 100%;
    padding: 14px;
    margin: 12px 0;
    border-radius: 8px;
    border: 1px solid #555;
    background-color: #1e1e1e;
    color: #fff;
    font-size: 1em;
}

button {
    width: 100%;
    padding: 14px;
    background-color: #3a3a3a;
    border: none;
    border-radius: 10px;
    color: #fff;
    font-size: 1.2em;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s, transform 0.2s;
}

button:hover {
    background-color: #4a4a4a;
    transform: translateY(-2px);
}

.message {
    margin-top: 15px;
    text-align: center;
    font-weight: bold;
}

.error {
    color: #ff5c5c;
}

.success {
    color: #5cff8d;
}

.login-link {
    text-align: center;
    margin-top: 20px;
}

.login-link a {
    color: #aaa;
    text-decoration: none;
}

.login-link a:hover {
    color: #fff;
}
</style>
</head>
<body>

<header>
    <h1>Quantum Arcade</h1>
</header>

<div class="container">
    <h2>Create Account</h2>

    <form action="signupLogic.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="email" name="email" placeholder="Email address" required>
        <input type="password" name="password" placeholder="Password" required>

        <button type="submit" name="signup">Sign Up</button>
    </form>

    <?php
    if(isset($_SESSION['signup_error'])){
        echo "<div class='message error'>".$_SESSION['signup_error']."</div>";
        unset($_SESSION['signup_error']);
    }

    if(isset($_SESSION['signup_success'])){
        echo "<div class='message success'>".$_SESSION['signup_success']."</div>";
        unset($_SESSION['signup_success']);
    }
    ?>

    <div class="login-link">
        Already have an account? <a href="login.php">Login</a>
    </div>
</div>

</body>
</html>

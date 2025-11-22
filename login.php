<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // your DB username
$password = "";     // your DB password
$dbname = "Trims_Quantum_Arcade";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle login
$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = trim($_POST['username']);
    $pass = trim($_POST['password']);
    
    // Fetch user from database
    $stmt = $conn->prepare("SELECT * FROM users WHERE username=? LIMIT 1");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        // Verify hashed password
        if (password_verify($pass, $row['password'])) {
            $_SESSION['username'] = $user;
            header("Location: index.php");
            exit();
        } else {
            $error = "Invalid username or password!";
        }
    } else {
        $error = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<style>body {
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
    padding: 50px 40px;  /* bigger padding for more space */
    border-radius: 12px;
    box-shadow: 0 0 15px #fff;
    width: 350px;         /* wider container */
    text-align: center;   /* center the header and text */
}

.signup-container h2 {
    margin-bottom: 30px; /* space below the title */
    text-align: center;  /* center the title */
    font-size: 28px;     /* optional: bigger for emphasis */
    font-weight: bold;
}


input[type="text"], input[type="password"], input[type="email"] {
    width: 80%;            /* slightly smaller to leave space */
    padding: 12px;
    margin: 15px 0;
    border: 1px solid #fff;
    border-radius: 6px;
    background-color: #000;
    color: #fff;
    display: block;
    margin-left: auto;
    margin-right: auto;   /* center the input boxes */
    font-size: 16px;
}

input[type="submit"] {
    width: 85%;
    padding: 12px;
    margin-top: 20px;
    border: none;
    border-radius: 6px;
    background-color: #fff;
    color: #000;
    font-weight: bold;
    cursor: pointer;
    font-size: 16px;
}

input[type="submit"]:hover {
    background-color: #ddd;
}

.error, .success {
    margin-top: 15px;
    text-align: center;
}

.error { color: #ff4d4d; }
.success { color: #4dff4d; }

</style>
</head>
<body>
<div class="login-container">
    <h2>Login</h2>
    <form method="POST" action="">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="submit" value="Login">
    </form>
    <?php if($error) { echo "<div class='error'>$error</div>"; } ?>
</div>
</body>
</html>

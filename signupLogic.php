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

// Get form data
$user = trim($_POST['username']);
$email = trim($_POST['email']);
$pass = trim($_POST['password']);
$confirm_pass = trim($_POST['confirm_password']);

// Basic validation
if($pass !== $confirm_pass){
    $_SESSION['signup_error'] = "Passwords do not match!";
    header("Location: signup.php");
    exit();
}

// Check if username or email already exists
$stmt = $conn->prepare("SELECT * FROM users WHERE username=? OR email=? LIMIT 1");
$stmt->bind_param("ss", $user, $email);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $_SESSION['signup_error'] = "Username or email already exists!";
    header("Location: signup.php");
    exit();
}

// Hash the password
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);


// Insert new user
$stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $user, $email, $hashed_pass);

if($stmt->execute()){
    $_SESSION['signup_success'] = "Account created successfully! You can now log in.";
    header("Location: signup.php");
    exit();
}else{
    $_SESSION['signup_error'] = "Error creating account. Try again!";
    header("Location: signup.php");
    exit();
}
?>

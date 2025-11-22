<?php
session_start();

// Connect to your database
$conn = new mysqli("localhost", "root", "", "Trims_Quantum_Arcade");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $username_email = trim($_POST['username_email']);
    $password = trim($_POST['password']);

    // Check empty fields
    if (empty($username_email) || empty($password)) {
        $_SESSION['login_error'] = "Please fill in all fields.";
        header("Location: login.php");
        exit();
    }

    // Check if user exists
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ? OR email = ?");
    $stmt->bind_param("ss", $username_email, $username_email);
    $stmt->execute();
    $result = $stmt->get_result();

    // USER MUST EXIST
    if ($result->num_rows !== 1) {
        $_SESSION['login_error'] = "User does not exist.";
        header("Location: login.php");
        exit();
    }

    $user = $result->fetch_assoc();

    // Verify password
    if (!password_verify($password, $user['password'])) {
        $_SESSION['login_error'] = "Incorrect password.";
        header("Location: login.php");
        exit();
    }

    // ✅ SUCCESS - user exists and password is correct
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];

    header("Location: index.php"); // Only real users reach here
    exit();
}
?>

<?php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "Trims_Quantum_Arcade";

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username_or_email = $_POST['username'];
$password = $_POST['password'];

// Prepare statement to prevent SQL injection
$stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE username = ? OR email = ?");
$stmt->bind_param("ss", $username_or_email, $username_or_email);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    // Verify password
    if (password_verify($password, $user['password_hash'])) {

        // Set session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];

        // Redirect to index.php
        header("Location: index.php");
        exit;
    } else {
        // Incorrect password
        echo "<h2 style='color:white;text-align:center;'>Incorrect password.</h2>";
        echo "<p style='text-align:center;'><a href='login.html'>Try again</a></p>";
        exit;
    }
} else {
    // Username or email not found
    echo "<h2 style='color:white;text-align:center;'>User not found.</h2>";
    echo "<p style='text-align:center;'><a href='login.html'>Try again</a></p>";
    exit;
}

// Close connections
$stmt->close();
$conn->close();
?>

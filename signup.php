<?php
session_start();
require "config.php"; // Make sure this file contains your $conn database connection

// Only process if form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Collect form data safely
    $username = trim($_POST['username'] ?? '');
    $email    = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Check for empty fields
    if (empty($username) || empty($email) || empty($password)) {
        die("All fields are required. <a href='signup.html'>Go back</a>");
    }

    // Hash the password
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL statement to avoid SQL injection
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password_hash);

    // Execute and handle errors
    try {
        $stmt->execute();
        // Redirect to login page after successful signup
        header("Location: login.html");
        exit;
    } catch (mysqli_sql_exception $e) {
        // Handle duplicate username/email error
        if (strpos($e->getMessage(), "Duplicate") !== false) {
            die("Username or email already exists. <a href='signup.html'>Go back</a>");
        } else {
            die("Database error: " . $e->getMessage());
        }
    }

} else {
    // Prevent direct access to signup.php
    die("Invalid request. <a href='signup.html'>Go back</a>");
}
?>

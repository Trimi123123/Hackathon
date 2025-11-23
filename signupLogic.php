<?php
$conn = new mysqli("localhost", "root", "", "Trims_Quantum_Arcade");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['signup'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $password);

    if ($stmt->execute()) {
        header("Location: login.php"); // ✅ send to login page
        exit();
    } else {
        header("Location: signup.php?error=exists");
        exit();
    }
}
?>

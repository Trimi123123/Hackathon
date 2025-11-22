<?php
$conn = new mysqli("localhost", "root", "", "Trims_Quantum_Arcade");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Connected to database successfully!";
}
?>

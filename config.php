<?php
$servername = "localhost";
$dbusername = "root";
$dbpassword = "";
$dbname = "Trims_Quantum_Arcade"; // must exactly match your database name

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

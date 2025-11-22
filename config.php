<?php
$servername = "localhost";
$dbusername = "root";   // default XAMPP username
$dbpassword = "";       // default XAMPP password
$dbname = "trim_quantum_arcade";

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";   // XAMPP runs MySQL on localhost
$user = "root";        // Default MySQL username in XAMPP
$password = "";        // Default password is empty
$database = "library_db"; // Database name

// Create a connection
$conn = new mysqli($host, $user, $password, $database);
$conn->set_charset("utf8mb4"); // Set character encoding

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

<?php
$host = "localhost";   // XAMPP runs MySQL on localhost
$user = "root";        // Default MySQL username in XAMPP
$password = "";        // Default password is empty
$database = "library_db"; // Database name

// Create a connection
$conn = new mysqli($host, $user, $password, $database);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connected successfully!";
}
?>

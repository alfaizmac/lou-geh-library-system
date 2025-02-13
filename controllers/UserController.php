<?php
require_once '../configs/db.php'; // Include database connection

if (isset($_POST['add_reader'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city'];
    $dob = $_POST['dob']; // Change the variable name if needed

    // Correct the SQL Query to use "date_of_birth" instead of "dob"
    $query = "INSERT INTO readers (first_name, last_name, city, date_of_birth) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $first_name, $last_name, $city, $dob);

    if ($stmt->execute()) {
        echo "✅ New reader added successfully!";
    } else {
        echo "❌ Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
}
?>

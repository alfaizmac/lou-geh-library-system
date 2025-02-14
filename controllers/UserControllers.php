<?php
require_once '../configs/db.php'; // Include database connection

if (isset($_POST['add_reader'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $city = $_POST['city'];
    $dob = $_POST['dob']; // Match the form input name

    // Prepare SQL Query
    $query = "INSERT INTO readers (first_name, last_name, city, date_of_birth) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $first_name, $last_name, $city, $dob);

    if ($stmt->execute()) {
        // Redirect to prevent form resubmission and show success message
        header("Location: ../readers.php?success=1");
        exit();
    } else {
        // Redirect with error message
        header("Location: ../readers.php?error=1");
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
